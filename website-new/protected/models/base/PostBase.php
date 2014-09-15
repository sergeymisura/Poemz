<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Post instead.
 * Base class for Post model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  integer topic_id Database column
 * @property  integer author_id Database column
 * @property  integer parent_id Database column
 * @property  mixed   created Database column
 * @property  mixed   message Database column
 * @property  User author Relation
 * @property  Post parent Relation
 * @property  Post[] posts Relation
 * @property  Topic topic Relation
 */
abstract class PostBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Post  An instance of Model class
	 */
	public static function model($className = 'Post')
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
		return 'post';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'author' => array(self::BELONGS_TO, 'User', 'author_id'),
			'parent' => array(self::BELONGS_TO, 'Post', 'parent_id'),
			'posts' => array(self::HAS_MANY, 'Post', 'parent_id'),
			'topic' => array(self::BELONGS_TO, 'Topic', 'topic_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  PostSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new PostSerializer($this);
	}
}
