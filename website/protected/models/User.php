<?php
/**
 * User Model class
 * 
 * @package  Poemz.Models
 */
class User extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  User  An instance of Model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Returns the name of the table
	 *
	 * @return  string  Name of the database table
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * Returns a list of attributes that we don't want to send in API response by default
	 * 
	 * @return  array  A list of attributes to hide
	 */
	public function hidden()
	{
		return array('password_hash', 'activation_code');
	}

	public static function createPasswordHash($password)
	{
		$salt = 'zW4c42mUudmt99N85mgFILyrIfmZFpVHAsJPcSNw';
		$hash = sha1($password . $salt);
		for ($i = 0; $i < 323; $i++)
		{
			$hash = sha1($hash . $salt);
		}
		return $hash;
	}
}
