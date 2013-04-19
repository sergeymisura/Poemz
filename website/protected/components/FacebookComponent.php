<?php
/**
 * Yii wrapper for Facebook SDK
 * 
 * @package  CanDo.Components
 */
class FacebookComponent extends CComponent
{
	/**
	 * @var  Facebook  An instance of Facebook SDK
	 */
	public $fb;

	/**
	 * @var  string  Facebook application ID
	 */
	public $appId;

	/**
	 * @var  string  Facebook application secret key
	 */
	public $secretKey;

	/**
	 * @var  string  Facebook application namespace
	 */
	public $namespace;

	/**
	 * Initializes the component
	 * 
	 * @return  void
	 */
	public function init()
	{
		Yii::import("application.vendors.facebook.*");
		require_once "facebook.php";

		$this->fb = new Facebook(array("appId" => $this->appId, "secret" => $this->secretKey));
	}

	/**
	 * Magic method that passess all calls to the original Facebook SDK class
	 * 
	 * @param   string  $name  Method name
	 * @param   array   $args  Method args
	 * 
	 * @return  mixed  Method result
	 * 
	 * @see CComponent::__call()
	 */
	public function __call($name, $args)
	{
		return call_user_func_array(array($this->fb, $name), $args);
	}
}
