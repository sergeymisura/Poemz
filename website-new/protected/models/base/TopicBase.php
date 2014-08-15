<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Topic instead.
 * Base class for Topic model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  Poem[] poems Relation
 * @property  Post[] posts Relation
 * @property  Recitation[] recitations Relation
 */
abstract class TopicBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Topic  An instance of Model class
	 */
	public static function model($className = 'Topic')
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
		return 'topic';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'poems' => array(self::HAS_MANY, 'Poem', 'topic_id'),
			'posts' => array(self::HAS_MANY, 'Post', 'topic_id'),
			'recitations' => array(self::HAS_MANY, 'Recitation', 'topic_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  TopicSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new TopicSerializer($this);
	}
}
