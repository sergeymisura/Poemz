<?php
/**
 * SiteController class
 *
 * @package  CanDo.Poemz.Controllers
 */
class SiteController extends PageController
{
	/**
	 * Page
	 *
	 * @return  void
	 */
	public function actionIndex()
	{
		/**
		 * @var  Poem[]  $poems
		 */
		$poems = Poem::model()->with('author')->findAll(array('limit' => 6));

		$this->setPageData('poems', $poems);
		$this->render('index');
	}

	public function actionAuthor($author_slug)
	{
		/**
		 * @var  Author  $author
		 */
		$author = Author::model()->findByAttributes(array('slug' => $author_slug));

		if ($author == null)
		{
			$this->notFound();
		}

		$this->setPageData('author', $author);
		$this->render('author', array('author' => $author));
	}

	public function actionPoem($author_slug, $poem_slug)
	{
		/**
		 * @var  Author  $author
		 * @var  Poem    $poem
		 */
		$author = Author::model()->findByAttributes(array('slug' => $author_slug));

		if ($author == null)
		{
			$this->notFound();
		}

		$poem = Poem::model()->findByAttributes(array('author_id' => $author->id, 'slug' => $poem_slug));

		if ($poem == null)
		{
			$this->notFound();
		}

		$this->contentClass = 'column-container';
		$this->setPageData('poem', $poem);
		$this->render('poem', array('poem' => $poem));
	}

	public function actionLogout()
	{
		if ($this->session != null)
		{
			$this->session->delete();
		}
		$this->redirect($this->createUrl('site/index'));
	}
}
