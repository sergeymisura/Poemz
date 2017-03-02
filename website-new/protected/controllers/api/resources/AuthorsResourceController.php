<?php
/**
 * Authors resource controller
 *
 * @package  CanDo.Poemz.Controllers.API.Resources
 */
class AuthorsResourceController extends ApiController
{
	/**
	 * Sends back a list of Authors
	 *
	 * @return  void
	 */
	public function actionList()
	{
		/**
		 * @var  Author[]  $authors
		 */
		$criteria = new CDbCriteria;

		$query = $this->request->getQuery('q');
		if ($query)
		{
			$criteria->addCondition('name like :query');
			$query = str_replace('%', '', $query);
			$query = str_replace('?', '', $query);
			$criteria->params[':query'] = '%' . $query . '%';
		}

		$count = Author::model()->count($criteria);

		$criteria->limit = 15;
		$criteria->offset = $this->request->getQuery('offset', 0);

		$authors = Author::model()->findAll($criteria);
		$this->send(
			array(
				'authors' => $authors,
				'count' => $count,
				'offset' => $criteria->offset
			)
		);
	}

	/**
	 * Sends back a requested instance of Author
	 *
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionGet($id)
	{
		/**
		 * @var  Author  $author
		 */
		if (is_numeric($id))
		{
			$author = Author::model()->with('poems')->findByPk($id);
		}
		else
		{
			$author = Author::model()->with('poems')->findByAttributes(array('slug' => $id));
		}

		if ($author == null)
		{
			$this->sendError(404, 'ERR_NOT_FOUND', 'Author is not found');
		}

		if ($this->request->getQuery('wiki') == 'true')
		{
			$api_url = 'http://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts|info&inprop=url&exsentences=10&titles=' . urlencode($author->name);
			$response = file_get_contents($api_url);
			if ($response)
			{
				$data = json_decode($response, true);
				if ($data && isset($data['query']) && isset($data['query']['pages']) && count($data['query']['pages']) > 0)
				{
					$ids = array_keys($data['query']['pages']);
					$page = $data['query']['pages'][$ids[0]];
					$author->wiki_url = $page['fullurl'];
					$author->wiki_excerpt = $page['extract'];
					$author->save();
				}
			}
		}

		$this->send(array('author' => $author));
	}

	/**
	 * Creates and sends back a new instance of Author
	 *
	 * @return void
	 */
	public function actionCreate()
	{
		/**
		 * @var  Author  $author
		 */

		if ($this->session == null)
		{
			$this->authFailed();
		}

		if (!isset($this->payload->name))
		{
			$this->sendError(400, 'ERR_INVALID', 'Author\'s name is required');
		}

		if (Author::model()->findByAttributes(array('name' => $this->payload->name)) != null)
		{
			$this->sendError(400, 'ERR_EXISTS', 'Author with this name already exists');
		}

		$author = new Author;
		$author->submitter_id = $this->session->user_id;
		$author->name = $this->payload->name;
		$author->slug = Model::slugify($author->name, 'author');
		$author->pullWikiInfo();
		$author->save();

		$this->send(
			array(
				'author' => $author
			)
		);
	}

	/**
	 * Updates and sends back a requested instance of Author
	 *
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionUpdate($id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Deletes a specified instance of Author
	 *
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionDelete($id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}
}
