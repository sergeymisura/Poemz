<?php
class MailGunComponent extends CComponent
{
	public $domain;
	public $apiKey;
	public $fromName;
	public $fromAddress;

	const BASE_URL = 'https://api.mailgun.net/v2/';

	public function init()
	{}

	public function send($message)
	{
		/**
		 * @var  Http  $http
		 */
		$http = Yii::app()->http;

		$message = array_merge(
			[
				'fromName' => $this->fromName,
				'fromAddress' => $this->fromAddress
			],
			$message
		);

		try
		{
			$http->request(self::BASE_URL . $this->domain . '/messages')
				->basicAuth('api', $this->apiKey)
				->post(
					[
						'from' => $this->address($message['fromName'], $message['fromAddress']),
						'to' => $this->address($message['toName'], $message['toAddress']),
						'subject' => $message['subject'],
						'text' => $message['text'],
						'html' => $message['html'],
					]
				);
		}
		catch (HttpCurlException $ex)
		{
			var_dump($ex);die();
			return false;
		}
		return true;
	}

	private function address($name, $email)
	{
		return $name . ' <' . $email . '>';
	}
}
