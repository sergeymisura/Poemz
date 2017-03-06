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
				'limit' => 10,
				'order' => 't.' . $order
			)
		);

		$this->send(array('recitations' => $recitations));
	}

	/**
	 * Sends back a list of user's Recitations
	 *
	 * @param   integer  $user_id  User ID
	 *
	 * @return  void
	 */
	public function actionListByUser($user_id)
	{
		/**
		 * @var  User  $user
		 */
		if (is_numeric($user_id))
		{
			$user = User::model()->findByPk($user_id);
		}
		else
		{
        	$user = User::model()->findByAttributes(['slug' => $user_id]);
		}

		if ($user == null)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'User not found');
		}

		$order = 'created desc';

		$requestedOrder = $this->request->getQuery('order');

		if ($requestedOrder == 'best' || $requestedOrder == 'votes')
		{
			$order = 'votes desc';
		}

		$count = Recitation::model()->countByAttributes(
			array(
				'performer_id' => $user->id
			)
		);

		$recitations = Recitation::model()->with(array('poem.author','topic.comments_count'))->findAllByAttributes(
			array(
				'performer_id' => $user->id
			),
			array(
				'offset' => $this->request->getQuery('index', 0),
				'limit' => 10,
				'order' => 't.' . $order
			)
		);

		$this->send(array('recitations' => $recitations, 'count' => $count));
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
		$recitation = Recitation::model()->with(array('performer', 'topic'))->findByPk($id, 'poem_id = :poem_id', array(':poem_id' => $poem_id));
		if ($recitation == null)
		{
			$this->sendError(404, 'ERR_NOT_FOUND', 'Recitation not found');
		}

		$this->send(array('recitation' => $recitation));
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
		$recitation = Recitation::model()->findByPk($id, 'poem_id = :poem_id', array(':poem_id' => $poem_id));
		if ($recitation == null)
		{
			$this->sendError(404, 'ERR_NOT_FOUND', 'Recitation not found');
		}

		$recitation->delete();
		$this->send();
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

	public function actionGetVote($poem_id, $id)
	{
		/**
		 * @var  Recitation      $recitation
		 * @var  RecitationVote  $vote
		 */

		if ($this->session == null)
		{
			$this->sendError(401, 'ERR_NOT_AUTHORIZED', 'Please log in first.');
		}

		$recitation = Recitation::model()->findByPk($id);

		if ($recitation == null || $recitation->poem_id != $poem_id)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Recitation not found');
		}

		$vote = RecitationVote::model()->findByAttributes(
			array(
				'recitation_id' => $recitation->id,
				'voter_id' => $this->session->user_id
			)
		);

		$this->send(
			array(
				'vote' => $vote == null ? null : $vote->direction
			)
		);
	}

	public function actionAddVote($poem_id, $id)
	{
		/**
		 * @var  Recitation      $recitation
		 * @var  RecitationVote  $vote
		 */

		if ($this->session == null)
		{
			$this->sendError(401, 'ERR_NOT_AUTHORIZED', 'Please log in first.');
		}

		$recitation = Recitation::model()->findByPk($id);

		if ($recitation == null || $recitation->poem_id != $poem_id)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Recitation not found');
		}

		if ($recitation->performer_id == $this->session->user_id)
		{
			$this->sendError('400', 'ERR_SELF', 'You cannot vote on your own performance!');
		}

		$visitor = Visitor::matchVisitor($this->request, $this->session);
		$count = Stat::model()->countByAttributes(
			array(
				'visitor_id' => $visitor->id,
				'recitation_id' => $recitation->id
			)
		);
		if ($count == 0)
		{
			$this->sendError('400', 'ERR_LISTEN', 'You cannot vote on the recitation you didn\'t listen!');
		}

		$vote = RecitationVote::model()->findByAttributes(
			array(
				'recitation_id' => $recitation->id,
				'voter_id' => $this->session->user_id
			)
		);

		if ($vote == null)
		{
			$vote = new RecitationVote;
			$vote->recitation_id = $recitation->id;
			$vote->voter_id = $this->session->user_id;
			$vote->voted = Model::getDbDate(null, true);
			$vote->direction = 1;
			$vote->save();

			$recitation->updateVotes();
		}

		$this->send(
			array(
				'vote' => $vote->direction,
				'votes' => $recitation->votes
			)
		);
	}

	public function actionRevokeVote($poem_id, $id)
	{
		/**
		 * @var  Recitation      $recitation
		 * @var  RecitationVote  $vote
		 */

		if ($this->session == null)
		{
			$this->sendError(401, 'ERR_NOT_AUTHORIZED', 'Please log in first.');
		}

		$recitation = Recitation::model()->findByPk($id);

		if ($recitation == null || $recitation->poem_id != $poem_id)
		{
			$this->sendError('404', 'ERR_NOT_FOUND', 'Recitation not found');
		}

		RecitationVote::model()->deleteAllByAttributes(
			array(
				'recitation_id' => $recitation->id,
				'voter_id' => $this->session->user_id
			)
		);

		$recitation->updateVotes();

		$this->send(
			array(
				'vote' => null,
				'votes' => $recitation->votes
			)
		);
	}
}
