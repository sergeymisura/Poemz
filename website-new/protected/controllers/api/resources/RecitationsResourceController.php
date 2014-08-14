<?php
/**
 * Recitations resource controller
 *
 * @package  CanDo.Poems.Controllers.API.Resources
 */
class RecitationsResourceController extends ApiController
{
	/**
	 * Sends back a list of Recitations
	 *
	 * @param   integer  $poem_id  Poem ID
	 *
	 * @return  void
	 */
	public function actionList($poem_id)
	{
		/**
		 * @var  Poem  $poem
		 */
		$poem = Poem::model()->findByPk($poem_id);

		if ($poem == null)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Poem not found');
		}

		$recitations = Recitation::model()->with('performer')->findAllByAttributes(
			array(
				'poem_id' => $poem_id
			),
			array(
				'offset' => $this->request->getQuery('index', 0),
				'limit' => 15,
				'order' => 't.' . $this->request->getQuery('order', 'created desc')
			)
		);

		$this->send(array('recitations' => $recitations));
	}

	/**
	 * Sends back a requested instance of Recitation
	 *
	 * @param   integer  $poem_id  Poem ID
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionGet($poem_id, $id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Creates and sends back a new instance of Recitation
	 *
	 * @param   integer  $poem_id  Poem ID

	 * @return void
	 */
	public function actionCreate($poem_id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Updates and sends back a requested instance of Recitation
	 *
	 * @param   integer  $poem_id  Poem ID
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionUpdate($poem_id, $id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}

	/**
	 * Deletes a specified instance of Recitation
	 *
	 * @param   integer  $poem_id  Poem ID
	 * @param   integer  $id  Instance ID
	 *
	 * @return  void
	 */
	public function actionDelete($poem_id, $id)
	{
		$this->sendError(501, 'ERR_NOT_IMPLEMENTED', 'The action you are requesting is not implemented');
	}
}
