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

		$visitor = null;

		if ($this->request->cookies->contains('poemz'))
		{
			$visitor = Visitor::findByCookie($this->request->cookies['poemz']->value);
		}
		else
		{
			$visitor = new Visitor;
		}

		if ($this->session)
		{
			if (count($this->session->user->visitors) > 0)
			{
				$visitor = $this->session->user->visitors[0];
			}
			else
			{
				if ($visitor->user_id != $this->session->user_id && $visitor->user_id != null)
				{
					$visitor = new Visitor;
				}
				if ($visitor->user_id == null)
				{
					$visitor->user_id = $this->session->user_id;
				}
			}
		}

		$visitor->save();

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

		$this->request->cookies['poemz'] = new CHttpCookie(
			'poemz',
			$visitor->cookieValue,
			array(
				'path' => Yii::app()->baseUrl != '' ? Yii::app()->baseUrl : '/',
				'expire' => time() + 365 * 24 * 60 * 60
			)
		);

		$this->send();
	}
}
