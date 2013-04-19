<?php
/**
 * Yii wrapper for CouldFiles API
 *
 * @package  CanDo.Components
 */
class CloudfilesComponent extends CComponent
{
	/**
	 * @var  string  API key
	 */
	public $key;

	/**
	 * @var  string  CloudFiles 
	 */
	public $username;

	/**
	 * @var  string  CloudFiles container to use to store project files
	 */
	public $container;

	/**
	 * @var  string  Prefix (pseudo-path) to prepend to all project files
	 */
	public $prefix;

	/**
	 * Initializes the component
	 * 
	 * @return  void
	 */
	public function init()
	{

	}

	/**
	 * Connects to CloudFiles and returns the container
	 * 
	 * @return  CF_Container  CloudFiles container
	 */
	public function getContainer()
	{
		Yii::import("application.vendors.cloudfiles.*");
		require_once "cloudfiles.php";

		$auth = new CF_Authentication($this->username, $this->key);
		$auth->authenticate();

		$conn = new CF_Connection($auth);
		return $conn->create_container($this->container);
	}

	/**
	 * Writes the file to CloudFiles and returns publicly accessible URL
	 * 
	 * @param   string   $name       Name of the file
	 * @param   string   $content    File content
	 * @param   boolean  $returnSsl  True for https:// link to be returned, false for http://
	 *  
	 * @return  string  Publicly available URL for the created file
	 */
	public function saveFile($name, $content, $returnSsl=false)
	{
		$container = $this->getContainer();
		$object = $container->create_object($this->prefix . "/" . $name);
		$object->write($content);
		return $returnSsl ? $object->public_ssl_uri() : $object->public_uri();
	}
}
