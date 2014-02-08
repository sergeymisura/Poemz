<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Recital instead.
 * Base class for Recital model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  integer poem_id Database column
 * @property  integer performer_id Database column
 * @property  mixed   created Database column
 * @property  integer latest Database column
 * @property  Poem poem Relation
 * @property  User performer Relation
 * @property  RecitalVote[] recital_votes Relation
 */
abstract class RecitalBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Recital  An instance of Model class
	 */
	public static function model($className = 'Recital')
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
			'poem' => array(self::BELONGS_TO, 'Poem', 'poem_id'),
			'performer' => array(self::BELONGS_TO, 'User', 'performer_id'),
			'recital_votes' => array(self::HAS_MANY, 'RecitalVote', 'recital_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  RecitalSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new RecitalSerializer($this);
	}
}
