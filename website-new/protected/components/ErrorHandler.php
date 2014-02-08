<?php
class ErrorHandler extends CErrorHandler
{
	public $source = '';
	public $exception = null;

	private $_issue;

	public function getError()
	{
		$error = parent::getError();
		$error['issue'] = $this->_issue;
		if ($this->exception)
		{
			$error['exception'] = $this->exception;
		}
		return $error;
	}

	protected function handleError($event)
	{
		$this->report(
			$this->source . '.php.error',
			'PHP error: ' . $event->message,
			array(
				'Source' => $event->file,
				'Line' => $event->line
			)
		);

		parent::handleError($event);
	}

	protected function handleException($exception)
	{
		$this->exception = $exception;
		$this->report(
			$this->source . '.php.exception',
			'PHP exception: ' . $exception->getMessage(),
			array(
				'Source' => $exception->getFile(),
				'Line' => $exception->getLine(),
				'Trace' => $exception->getTraceAsString()
			)
		);

		parent::handleException($exception);
	}

	private function report($source, $message, $details)
	{
		$user_id = null;

		if (Yii::app() instanceof CWebApplication)
		{
			$details['GET'] = json_encode($_GET);
			$details['POST'] = json_encode($_POST);
			if (Yii::app()->controller && Yii::app()->controller->session)
			{
				$user_id = Yii::app()->controller->session->user_id;
			}
		}

		$this->_issue = Issue::report(
			$source,
			'severe',
			$message,
			$details,
			$user_id
		);

		if (Yii::app() instanceof CWebApplication)
		{
			if (Yii::app()->controller instanceof ApiController)
			{
				$data = array('issue_id' => $this->_issue->id);
				if (YII_DEBUG)
				{
					$data['issue'] = $this->_issue;
				}
				Yii::app()->controller->sendError(
					500,
					'ERR_UNEXPECTED',
					'An unexpected error has occurred',
					$data
				);
			}
		}
	}
}
