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
}
