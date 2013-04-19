<?php
/**
 * SendGrid Web API implementation
 * 
 * @package  CanDo.Components
 *
 */
class SendGridComponent
{
	/**
	 * @var  string  SendGrid API user
	 */
	public $user;

	/**
	 * @var  string  SendGrid API key
	 */
	public $key;

	/**
	 * @var  string  Address to send emails from
	 */
	public $from;

	/**
	 * @var  string  SendGrid API endpoint
	 */
	public $endpoint = "http://sendgrid.com/api/mail.send.json";

	/**
	 * Initializes the component
	 * 
	 * @return  void
	 */
	public function init()
	{
	}

	/**
	 * Sends an email to the specified recipient
	 * 
	 * @param   string  $toName      Recipient name
	 * @param   string  $toAddress   Recipient email address
	 * @param   string  $subject     Email subject
	 * @param   string  $body        Email body
	 * @param   array   $additional  Additional SendGrid Web API parameters
	 * 
	 * @return  boolean  True if the email has been sent successfully
	 */
	public function send($toName, $toAddress, $subject, $body, $additional=array())
	{
		$params = array(
			"api_user" => $this->user,
			"api_key" => $this->key,
			"from" => $this->from,
			"to" => $toAddress,
			"toname" => $toName,
			"subject" => $subject,
			"html" => $body
		);

		$c = curl_init($this->endpoint);

		curl_setopt_array(
			$c,
			array(
				CURLOPT_POST => true,
				CURLOPT_POSTFIELDS => array_merge($params, $additional),
				CURLOPT_HEADER => false,
				CURLOPT_RETURNTRANSFER => true
			)
		);
		$result = curl_exec($c);
		$result = json_decode($result, true);
		curl_close($c);
		return is_array($result) && $result["message"] == "success";
	}
}
