<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use RecitalVote instead.
 * Base class for RecitalVote model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  integer recital_id Database column
 * @property  integer voter_id Database column
 * @property  mixed   voted Database column
 * @property  integer direction Database column
 * @property  Recital recital Relation
 * @property  User voter Relation
 */
abstract class RecitalVoteBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  RecitalVote  An instance of Model class
	 */
	public static function model($className = 'RecitalVote')
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
		return 'recital_vote';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'recital' => array(self::BELONGS_TO, 'Recital', 'recital_id'),
			'voter' => array(self::BELONGS_TO, 'User', 'voter_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  RecitalVoteSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new RecitalVoteSerializer($this);
	}
}
