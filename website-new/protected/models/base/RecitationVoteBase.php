<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use RecitationVote instead.
 * Base class for RecitationVote model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  integer recitation_id Database column
 * @property  integer voter_id Database column
 * @property  mixed   voted Database column
 * @property  integer direction Database column
 * @property  Recitation recitation Relation
 * @property  User voter Relation
 */
abstract class RecitationVoteBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  RecitationVote  An instance of Model class
	 */
	public static function model($className = 'RecitationVote')
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
		return 'recitation_vote';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'recitation' => array(self::BELONGS_TO, 'Recitation', 'recitation_id'),
			'voter' => array(self::BELONGS_TO, 'User', 'voter_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  RecitationVoteSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new RecitationVoteSerializer($this);
	}
}
