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
		$poems = Poem::newest();

		$this->setPageData('poems', $poems);
		$this->setPageData('recitations', Poem::topRecitations($poems));
		$this->render('index');
	}

	public function actionAuthor($author_slug)
	{
		/**
		 * @var  Author  $author
		 */
		$author = Author::model()->with('poems.recitations_count')->findByAttributes(array('slug' => $author_slug));

		if ($author == null)
		{
			$this->notFound();
		}

		$title_letters = Yii::app()->db->createCommand()
			->selectDistinct('ucase(left(title, 1)) first_letter')
			->from('poem')
			->where('author_id = :author')
			->having('first_letter >= \'A\' and first_letter <= \'Z\'')
			->order('first_letter')
			->queryColumn(array(':author' => $author->id));

		$line_letters = Yii::app()->db->createCommand()
			->selectDistinct('ucase(left(first_line, 1)) first_letter')
			->from('poem')
			->where('author_id = :author')
			->having('first_letter >= \'A\' and first_letter <= \'Z\'')
			->order('first_letter')
			->queryColumn(array(':author' => $author->id));

		$this->setPageData('author', $author);
		$this->setPageData('title_letters', $title_letters);
		$this->setPageData('line_letters', $line_letters);
		$this->render(
			'author',
			array(
				'author' => $author
			)
		);
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

		if ($poem->topic_id == null)
		{
			$topic = new Topic;
			$topic->save();

			$poem->topic_id = $topic->id;
			$poem->save();
		}

		$this->contentClass = 'column-container';
		$this->setPageData('poem', $poem);
		$this->render('poem', array('poem' => $poem));
	}

	public function actionNew($author_slug=null)
	{
		if ($author_slug)
		{
			$author = Author::model()->findByAttributes(array('slug' => $author_slug));
			if ($author == null)
			{
				$this->notFound();
			}
			$this->setPageData('author', $author);
		}
		$this->render('new');
	}

	public function actionLogout()
	{
		if ($this->session != null)
		{
			$this->session->delete();
		}
		$this->redirect($this->createUrl('site/index'));
	}

	public function actionSearch()
	{
		$query = $this->request->getQuery('q', '');
		if ($query == '')
		{
			$this->redirect($this->createUrl('site/index'));
		}

		$authors = Author::model()->findAll(
			'name like :query',
			array(
				':query' => '%' . $query . '%'
			)
		);

		$poems = Poem::model()->findAll(
			'title like :query or first_line like :query',
			array(
				':query' => '%' . $query . '%'
			)
		);

		$this->render(
			'search',
			array(
				'authors' => $authors,
				'poems' => $poems
			)
		);
	}
}
