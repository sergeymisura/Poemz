<?php
class SearchApiController extends ApiController
{
	public function actionIndex()
	{
		$query = $this->request->getQuery('q', '');
		if ($query == '')
		{
			$this->send(array(
				'authors' => array(),
				'poems' => array(),
				'users' => array()
			));
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

		$users = User::model()->with('author')->findAll(
			'username like :query',
			array(
				':query' => '%' . $query . '%'
			)
		);

		$this->send(
			array(
				'authors' => $authors,
				'poems' => $poems,
				'users' => $users,
				'query' => $query
			)
		);
	}
}
