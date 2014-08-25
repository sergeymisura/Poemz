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
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
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
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
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
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
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
