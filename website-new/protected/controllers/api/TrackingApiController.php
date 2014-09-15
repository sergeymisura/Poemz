<?php
class TrackingApiController extends ApiController
{
	public function actionIndex()
	{
		/**
		 * @var  Recitation  $recitation
		 */

		if (!isset($this->payload->recitation_id))
		{
			$this->sendError(400, 'ERR_INVALID', 'Recitation id is required');
		}

		if (!isset($this->payload->hash))
		{
			$this->sendError(400, 'ERR_INVALID', 'Hash is required');
		}

		$recitation = Recitation::model()->findByPk($this->payload->recitation_id);
		if ($recitation == null)
		{
			$this->sendError(404, 'ERR_NOT_FOUND', 'Recitation is not found');
		}

		$visitor = Visitor::matchVisitor($this->request, $this->session);

		$stat_record = Stat::model()->findByAttributes(
			array(
				'visitor_id' => $visitor->id,
				'recitation_id' => $recitation->id,
				'stat_hash' => $this->payload->hash
			)
		);

		if ($stat_record == null)
		{
			$stat_record = new Stat;
			$stat_record->visitor_id = $visitor->id;
			$stat_record->recitation_id = $recitation->id;
			$stat_record->listened = Model::getDbDate(null, true);
			$stat_record->stat_hash = $this->payload->hash;
			$stat_record->save();
		}

		$this->send();
	}
}
