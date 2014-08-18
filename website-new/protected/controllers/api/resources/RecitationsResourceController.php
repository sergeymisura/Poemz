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

		$order = 'created desc';

		if ($this->request->getQuery('order') == 'best')
		{
			$order = 'votes desc';
		}

		$recitations = Recitation::model()->with(array('performer','topic.comments_count'))->findAllByAttributes(
			array(
				'poem_id' => $poem_id
			),
			array(
				'offset' => $this->request->getQuery('index', 0),
				'limit' => 15,
				'order' => 't.' . $order
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

	public function actionPrepare($poem_id, $id)
	{
		/**
		 * @var  Poem        $poem
		 * @var  Recitation  $recitation
		 */
		$poem = Poem::model()->findByPk($poem_id);

		if ($poem == null)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Poem not found');
		}

		$recitation = Recitation::model()->findByPk($id);

		if ($recitation == null || $recitation->poem_id != $poem_id)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Recitation not found');
		}

		$path = Yii::app()->basePath . '/../assets/media/' . $recitation->id . '.mp3';
		if (!file_exists($path))
		{
			file_put_contents($path, $recitation->recitation_data->data);
		}

		$this->send(array('media' => Yii::app()->baseUrl . '/assets/media/' . $recitation->id . '.mp3'));
	}
}
