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

	public function actionSlugify()
	{
		/**
		 * @var  Author[]  $authors
		 * @var  Poem[]  $poems
		 */

		$authors = Author::model()->findAll();
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
}
