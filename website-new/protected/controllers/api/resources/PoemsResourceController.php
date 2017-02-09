<?php
/**
 * Poems resource controller
 *
 * @package  Poemz.Controllers.API.Resources
 */
class PoemsResourceController extends ApiController
{
	/**
	 * Sends back a list of Poems
	 *
	 * @param   integer  $author_id
	 *
	 * @return  void
	 */
	public function actionList($author_id)
	{
		/**
		 * @var  Author  $author
		 * @var  Poem[]  $poems
		 */

		$author = Author::model()->findByPk($author_id);
		if ($author == null)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Author not found');
		}

		$criteria = new CDbCriteria;

		$criteria->addCondition('author_id = :author');
		$criteria->params['author'] = $author_id;

		$query = $this->request->getQuery('q');
		if ($query)
		{
			$criteria->addCondition('(title like :query or first_line like :query)');
			$query = str_replace('%', '', $query);
			$query = str_replace('?', '', $query);
			$criteria->params[':query'] = $query . '%';
		}

		$count = Poem::model()->count($criteria);

		$criteria->limit = 15;
		$criteria->offset = $this->request->getQuery('offset', 0);

		$poems = Poem::model()->findAll($criteria);
		$this->send(
			array(
				'poems' => $poems,
				'count' => $count,
				'offset' => $criteria->offset
			)
		);
	}

	public function actionMixedList($list)
	{
		$count = Poem::model()->count();
		$results = array();
		$offset = $this->request->getQuery('offset', 0);

		switch ($list)
		{
			case 'best':
				$results = Poem::best($offset);
				break;
			case 'random':
				$results = Poem::random();
				break;
			case 'newest':
				$results = Poem::newest($offset);
				break;
			case 'favorite':
				$results = Poem::favorite($this->session->user, $offset);
				break;
			default:
				$this->sendError(404, 'ERR_NOT_FOUND', 'Unknown list');
		}
		$this->send(
			array(
				'poems' => $results,
				'recitations' => Poem::topRecitations($results),
				'count' => $count,
				'offset' => $offset
			)
		);
	}

	/**
	 * Sends back a requested instance of Poem
	 *
	 * @param   integer  $author_id
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionGet($author_id, $id)
	{
		if (is_numeric($author_id))
		{
			$author = Author::model()->findByPk($author_id);
		}
		else
		{
			$author = Author::model()->findByAttributes(array('slug' => $author_id));
		}

		if ($author == null)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Author not found');
		}

		$conditions = array(
			'author_id' => $author->id
		);
		if (is_numeric($id))
		{
			$conditions['id'] = $id;
		}
		else
		{
			$conditions['slug'] = $id;
		}
		$poem = Poem::model()->with('author', 'recitations', 'poem_text')->findByAttributes($conditions);

		foreach ($poem->recitations as $recitation)
		{
			$recitation->getRelated('performer');
		}

		if ($poem == null)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Poem not found');
		}

		$this->send(
			array(
				'poem' => $poem
			)
		);
	}

	/**
	 * Creates and sends back a new instance of Poem
	 *
	 * @param   integer  $author_id
	 *
	 * @return void
	 */
	public function actionCreate($author_id)
	{
		/**
		 * @var  Author  $author
		 */

		if ($this->session == null)
		{
			$this->authFailed();
		}

		$author = Author::model()->findByPk($author_id);
		if ($author == null)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Author not found');
		}

		if (!isset($this->payload->title))
		{
			$this->sendError(400, 'ERR_INVALID', 'Title is required');
		}

		if (!isset($this->payload->text))
		{
			$this->sendError(400, 'ERR_INVALID', 'Text is required');
		}

		$text = trim($this->payload->text);

		$poem = new Poem;
		$poem->author_id = $author->id;
		$poem->submitted_by = $this->session->user_id;
		$poem->title = $this->payload->title;
		$poem->slug = Model::slugify($poem->title, 'poem');
		$poem->first_line = Poem::extractFirstLine($text);
		$poem->save();

		$poem_text = new PoemText;
		$poem_text->poem_id = $poem->id;
		$poem_text->text = $text;
		$poem_text->save();

		$poem->getRelated('poem_text');

		$this->send(array('poem' => $poem));
	}

	/**
	 * Updates and sends back a requested instance of Poem
	 *
	 * @param   integer  $author_id
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionUpdate($author_id, $id)
	{
		/**
		 * @var  Poem  $poem
		 */

		if ($this->session == null)
		{
			$this->authFailed();
		}

		$poem = Poem::model()->findByAttributes(
			array(
				'id' => $id,
				'author_id' => $author_id
			)
		);

		if ($poem == null)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Poem not found');
		}

		$modified = false;

		if (isset($this->payload->title))
		{
			$poem->title = $this->payload->title;
			$modified = true;
		}

		if (isset($this->payload->text))
		{
			$text = trim($this->payload->text);

			$poem->poem_text->text = $text;
			$poem->poem_text->save();

			$poem->first_line = Poem::extractFirstLine($text);

			$modified = true;
		}

		if ($modified)
		{
			$poem->submitted = Poem::getDbDate(null, true);
			$poem->submitted_by = $this->session->user_id;
			$poem->save();
		}

		$this->send(array('poem' => $poem));
	}

	/**
	 * Deletes a specified instance of Poem
	 *
	 * @param   integer  $author_id
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionDelete($author_id, $id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}
}
