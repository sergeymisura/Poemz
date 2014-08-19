<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use PoemText instead.
 * Base class for PoemText model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer poem_id Database column
 * @property  mixed   text Database column
 * @property  Poem poem Relation
 */
abstract class PoemTextBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  PoemText  An instance of Model class
	 */
	public static function model($className = 'PoemText')
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
		return 'poem_text';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'poem' => array(self::BELONGS_TO, 'Poem', 'poem_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  PoemTextSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new PoemTextSerializer($this);
	}
}
