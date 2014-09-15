<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Stat instead.
 * Base class for Stat model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  mixed   id Database column
 * @property  mixed   visitor_id Database column
 * @property  integer recitation_id Database column
 * @property  mixed   listened Database column
 * @property  string  stat_hash Database column
 * @property  Visitor visitor Relation
 * @property  Recitation recitation Relation
 */
abstract class StatBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Stat  An instance of Model class
	 */
	public static function model($className = 'Stat')
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
		return 'stat';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'visitor' => array(self::BELONGS_TO, 'Visitor', 'visitor_id'),
			'recitation' => array(self::BELONGS_TO, 'Recitation', 'recitation_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  StatSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new StatSerializer($this);
	}
}
