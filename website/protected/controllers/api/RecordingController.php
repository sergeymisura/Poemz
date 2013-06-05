<?php 

class RecordingController extends ApiController
{
	public function actionSave()
	{
		if ($this->user)
		{
			$this->user->preview_ready = 0;
			$this->user->save();

			$path_part = '/assets/media/' . $this->user->id . '.preview';
			$wav_path = Yii::app()->basePath . '/..' . $path_part. '.wav';
			$mp3_path = Yii::app()->basePath . '/..' . $path_part . '.mp3';
			file_put_contents($wav_path, file_get_contents('php://input'));
			$output = array();
			if (file_exists($mp3_path))
			{
				unlink($mp3_path);
			}
			exec('normalize-audio ' . $wav_path, $output);
			exec('avconv -y -i ' . $wav_path . ' ' . $mp3_path, $output);
			if (file_exists($mp3_path))
			{
				$this->user->preview_ready = 1;
				$this->user->save();
				$this->send(array('url' => Yii::app()->baseUrl . $path_part . '.mp3'));
			}
			else
			{
				$this->sendError('500', 'ERR_FAILED', 'Audio processing failed.');
			}
		}
		else
		{
			$this->authFailed();
		}
	}

	public function actionPreviewReady()
	{
		if ($this->user)
		{
			$this->send(array('ready' => $this->user->preview_ready));
		}
		else
		{
			$this->authFailed();
		}
	}
	
	public function actionSubmit($poem)
	{
		if ($this->user)
		{
			$mp3_path = Yii::app()->basePath . '/../assets/media/' . $this->user->id . '.preview.mp3';
			if (file_exists($mp3_path))
			{
				$recital = Recital::model()->updateAll(
					array('latest' => 0),
					'poem_id = :poem and performer_id = :performer and latest = 1',
					array(
						':poem' => $poem,
						':performer' => $this->user->id
					)
				);
				$recital = new Recital();
				$recital->poem_id = $poem;
				$recital->performer_id = $this->user->id;
				$recital->created = Model::getDbDate();
				$recital->save();
				$recital->getRelated('performer');
				rename($mp3_path, Yii::app()->basePath . '/../assets/media/recital.' . $recital->id . '.mp3');
				$this->send(array('recital' => $recital));
			}
			else
			{
				$this->sendError(500, 'ERR_NO_PREVIEW', 'Preview is not available.');
			}
		}
		else
		{
			$this->authFailed();
		}
	}
}
