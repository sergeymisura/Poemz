<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Recitation instead.
 * Base class for Recitation model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  integer poem_id Database column
 * @property  integer performer_id Database column
 * @property  mixed   created Database column
 * @property  integer latest Database column
 * @property  integer votes Database column
 * @property  integer topic_id Database column
 * @property  User performer Relation
 * @property  Poem poem Relation
 * @property  Topic topic Relation
 * @property  RecitationData recitation_data Relation
 * @property  RecitationVote[] recitation_votes Relation
 * @property  Stat[] stats Relation
 */
abstract class RecitationBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Recitation  An instance of Model class
	 */
	public static function model($className = 'Recitation')
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
		return 'recitation';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'performer' => array(self::BELONGS_TO, 'User', 'performer_id'),
			'poem' => array(self::BELONGS_TO, 'Poem', 'poem_id'),
			'topic' => array(self::BELONGS_TO, 'Topic', 'topic_id'),
			'recitation_data' => array(self::HAS_ONE, 'RecitationData', 'recitation_id'),
			'recitation_votes' => array(self::HAS_MANY, 'RecitationVote', 'recitation_id'),
			'stats' => array(self::HAS_MANY, 'Stat', 'recitation_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  RecitationSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new RecitationSerializer($this);
	}
}
