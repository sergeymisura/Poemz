<?php
class RecordingApiController extends ApiController
{
	public function actionUpload()
	{
		if ($this->session == null)
		{
			$this->sendError(401, 'ERR_NOT_AUTHORIZED', 'User not authorized');
		}
		if (isset($_FILES['content']))
		{
			$output = array();
			$wav_path = Yii::app()->basePath . '/../assets/previews/' . $this->session->user_id . '.wav';
			$mp3_path = Yii::app()->basePath . '/../assets/previews/' . $this->session->user_id . '.mp3';

			if (file_exists($wav_path))
			{
				unlink($wav_path);
			}

			if (file_exists($mp3_path))
			{
				unlink($mp3_path);
			}

			move_uploaded_file(
				$_FILES['content']['tmp_name'],
				$wav_path
			);

			exec('normalize-audio ' . $wav_path, $output);
			exec('avconv -y -i ' . $wav_path . ' ' . $mp3_path, $output);

			unlink($wav_path);
			if (file_exists($mp3_path))
			{
				$this->send();
			}
			$this->sendError(500, 'ERR_FAILED', 'Failed to process the data');
		}
		$this->sendError(400, 'ERR_INVALID', 'Invalid request');
	}

	public function actionDiscard()
	{
		if ($this->session == null)
		{
			$this->sendError(401, 'ERR_NOT_AUTHORIZED', 'User not authorized');
		}

		$mp3_path = Yii::app()->basePath . '/../assets/previews/' . $this->session->user_id . '.mp3';

		if (file_exists($mp3_path))
		{
			unlink($mp3_path);
		}
		$this->send();
	}

	public function actionKeep()
	{
		/**
		 * @var  Poem  $poem
		 */
		if ($this->session == null)
		{
			$this->sendError(401, 'ERR_NOT_AUTHORIZED', 'User not authorized');
		}

		$mp3_path = Yii::app()->basePath . '/../assets/previews/' . $this->session->user_id . '.mp3';
		$content = file_get_contents($mp3_path);

		if ($content == null)
		{
			$this->sendError(400, 'ERR_NO_PREVIEW', 'No preview available');
		}

		if (!isset($this->payload->poem_id))
		{
			$this->sendError(400, 'ERR_INVALID', 'Poem ID is required');
		}

		$poem = Poem::model()->findByPk($this->payload->poem_id);
		if ($poem == null)
		{
			$this->sendError(400, 'ERR_INVALID', 'Invalid poem ID');
		}

		$recitation = new Recitation;
		$recitation->performer_id = $this->session->user_id;
		$recitation->poem_id = $poem->id;
		$recitation->created = Model::getDbDate(null, true);
		$recitation->save();

		$data = new RecitationData;
		$data->recitation_id = $recitation->id;
		$data->data = $content;
		$data->save();

		$this->send(array('recitation' => $recitation));
	}
}
