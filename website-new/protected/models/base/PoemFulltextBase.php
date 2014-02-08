<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use PoemFulltext instead.
 * Base class for PoemFulltext model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  string  word Database column
 * @property  integer poem_id Database column
 * @property  integer weight Database column
 * @property  Poem poem Relation
 */
abstract class PoemFulltextBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  PoemFulltext  An instance of Model class
	 */
	public static function model($className = 'PoemFulltext')
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
		return 'poem_fulltext';
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
	 * @return  PoemFulltextSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new PoemFulltextSerializer($this);
	}
}
