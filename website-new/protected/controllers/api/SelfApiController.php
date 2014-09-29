<?php
class SelfApiController extends ApiController
{
	public function actionVotes()
	{
		if ($this->session == null)
		{
			$this->sendError(401, 'ERR_NOT_AUTHENTICATED', 'Please log in first');
		}
		$id_strings = explode(',', $this->request->getQuery('recitations', ''));
		$ids = [];
		$votes = [];
		foreach ($id_strings as $str)
		{
			$id = intval($str);
			$ids[] = $id;
			$votes[$id] = false;
		}
		$reader = Yii::app()->db->createCommand()
			->select('recitation_id')
			->from('recitation_vote')
			->where('recitation_id in (' . implode(',', $ids) . ') and voter_id = :voter')
			->query([':voter' => $this->session->user_id]);
		foreach ($reader as $row)
		{
			$votes[$row['recitation_id']] = true;
		}
		$this->send(['votes' => $votes]);
	}
}
