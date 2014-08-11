<?php
class RecordingController extends ApiController
{
	public function actionUpload()
	{
		if ($this->session == null)
		{
			$this->sendError(401, 'ERR_NOT_AUTHORIZED', 'User not authorized');
		}
		if (isset($_FILES['content']))
		{
			move_uploaded_file(
				$_FILES['content']['tmp_name'],
				Yii::app()->basePath . '/../assets/previews/' . $this->session->user_id . '.wav'
			);
		}
		$this->sendError(400, 'ERR_INVALID', 'Invalid request');
	}
}
