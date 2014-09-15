<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Visitor instead.
 * Base class for Visitor model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  mixed   id Database column
 * @property  integer user_id Database column
 * @property  Stat[] stats Relation
 * @property  User user Relation
 */
abstract class VisitorBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Visitor  An instance of Model class
	 */
	public static function model($className = 'Visitor')
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
		return 'visitor';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'stats' => array(self::HAS_MANY, 'Stat', 'visitor_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  VisitorSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new VisitorSerializer($this);
	}
}
