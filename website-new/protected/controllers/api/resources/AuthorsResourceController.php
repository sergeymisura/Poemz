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
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
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
		$author = Author::model()->findByPk($id);

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
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
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
