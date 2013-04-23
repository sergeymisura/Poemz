<?php
/**
 * User Model class
 * 
 * @package  Poemz.Models
 */
class Recital extends Model
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
		return 'recital';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'performer' => array(self::BELONGS_TO, 'User', 'performer_id')
		);
	}

	/**
	 * Returns a list of attributes that we don't want to send in API response by default
	 * 
	 * @return  array  A list of attributes to hide
	 */
	public function hidden()
	{
		return array();
	}

}

