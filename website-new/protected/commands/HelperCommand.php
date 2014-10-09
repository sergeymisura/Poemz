<?php
class HelperCommand extends CConsoleCommand
{
	public function actionBuild()
	{
		ClientScript::buildResources(Yii::app()->basePath . '/config/resources.json');
	}

	public function actionPassword($id, $password)
	{
		/**
		 * @var  User  $user
		 */
		$user = User::model()->findByPk($id);
		if ($user == null)
		{
			echo "User not found.\n";
			return;
		}

		$user->password_hash = $user->createPasswordHash($password);
		$user->save();

		echo "Password changed for " . $user->email . ".\n";
	}

	public function actionAvatar($author_id, $file)
	{
		/**
		 * @var  Author  $author
		 */
		$author = Author::model()->findByPk($author_id);

		$image = new Image;
		$image->content = @file_get_contents($file);
		$image->save();

		$author->avatar_id = $image->id;
		$author->save();
	}

	public function actionUserAvatar($user, $file)
	{
		/**
		 * @var  User  $user
		 */
		$user = User::model()->findByAttributes(['username' => $user]);

		$image = new Image;
		$image->content = @file_get_contents($file);
		$image->save();

		$user->avatar_id = $image->id;
		$user->save();
	}

	public function actionSlugify()
	{
		/**
		 * @var  Author[]  $authors
		 * @var  Poem[]  $poems
		 */

		/*$authors = Author::model()->findAll();
		foreach ($authors as $author)
		{
			$author->slug = self::slugify($author->name);
			$author->save();
		}

		$poems = Poem::model()->findAll();
		foreach ($poems as $poem)
		{
			$poem->slug = self::slugify($poem->title);
			$poem->save();
		}*/
	}

	public function actionFirstLine()
	{
		/**
		 * @var  Poem[]  $poems
		 */

		$poems = Poem::model()->with('poem_text')->findAll();
		foreach ($poems as $poem)
		{
			$poem->first_line = Poem::extractFirstLine($poem->poem_text->text);
			$poem->save();
			echo $poem->first_line . "\n";
		}
	}

	static public function slugify($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// lowercase
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text))
		{
			return 'n-a';
		}

		return $text;
	}

	/**
	 * @param   XmlWriter  $writer
	 * @param   string     $location
	 * @param   int        $last_modified
	 * @param   string     $change_freq
	 */
	private function sitemapWriteUrl($writer, $location, $last_modified, $change_freq='daily')
	{
		$writer->startElement('url');
		$writer->writeElement('loc', $location);
		$writer->writeElement('lastmod', date('Y-m-d', $last_modified));
		$writer->writeElement('changefreq', $change_freq);
		$writer->endElement();
	}

	public function actionSitemap($baseUrl)
	{
		/**
		 * @var  Author[]  $authors
		 */
		$writer = new XMLWriter;
		$writer->openUri(Yii::app()->basePath . '/../sitemap.xml');

		$writer->startDocument('1.0', 'utf-8');
		$writer->startElement('urlset');
		$writer->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
		$writer->writeAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
		$writer->writeAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

		$this->sitemapWriteUrl($writer, $baseUrl . '/', time());

		$authors = Author::model()->findAll();
		foreach ($authors as $author)
		{
			$update = Yii::app()->db->createCommand()
				->select('max(submitted)')
				->from('poem')
				->where('author_id = :author')
				->queryScalar(array('author' => $author->id));

			$update_time = $update == null ? 0 : strtotime($update);
			$submitted_time = strtotime($author->submitted);
			$this->sitemapWriteUrl($writer, $baseUrl . '/' . $author->slug , max($update_time, $submitted_time));

			foreach ($author->poems as $poem)
			{
				$update = Yii::app()->db->createCommand()
					->select('max(created)')
					->from('recitation')
					->where('poem_id = :poem')
					->queryScalar(array('poem' => $poem->id));

				$update_time = $update == null ? 0 : strtotime($update);
				$submitted_time = strtotime($poem->submitted);
				$this->sitemapWriteUrl($writer, $baseUrl . '/' . $author->slug . '/' . $poem->slug, max($update_time, $submitted_time));
			}
		}

		$writer->endElement();
		$writer->endDocument();
		$writer->flush();

		file_put_contents(
			Yii::app()->basePath . '/../robots.txt',
			file_get_contents(Yii::app()->basePath . '/../robots.txt.dist') .
			'Sitemap: ' . $baseUrl . '/sitemap.xml' . "\n"
		);
	}

	public function actionExport()
	{
		/**
		 * @var  Poem[]  $poemz
		 */
		$f = fopen('php://output', 'w');
		$poemz = Poem::model()->with('author')->findAll();
		foreach ($poemz as $poem)
		{
			fputcsv($f, [$poem->title, $poem->first_line, $poem->author->name]);
		}
		fclose($f);
	}

	public function actionPermissions()
	{
		$data = require_once(__DIR__ . '/../config/roles.php');
		foreach ($data['permissions'] as $permission_id)
		{
			$permission = Permission::model()->findByPk($permission_id);
			if ($permission == null)
			{
				$permission = new Permission;
				$permission->id = $permission_id;
				$permission->save();
			}
		}

		foreach ($data['roles'] as $role_data)
		{
			$role = Role::model()->findByPk($role_data[0]);
			if ($role == null)
			{
				$role = new Role;
				$role->id = $role_data[0];
				$role->save();
			}
			foreach ($role_data[1] as $permission_id)
			{
				$permission = Permission::model()->findByPk($permission_id);
				if ($permission == null)
				{
					throw new Exception('Unknown permission: ' . $permission_id);
				}

				$role_permission = RolePermission::model()->findByAttributes([
					'role_id' => $role->id,
					'permission_id' => $permission->id
				]);
				if ($role_permission == null)
				{
					$role_permission = new RolePermission;
					$role_permission->role_id = $role->id;
					$role_permission->permission_id = $permission->id;
					$role_permission->save();
				}
			}
		}

	}
}
