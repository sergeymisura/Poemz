<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use User instead.
 * Base class for User model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  string  username Database column
 * @property  string  email Database column
 * @property  string  password_hash Database column
 * @property  mixed   created Database column
 * @property  integer active Database column
 * @property  string  activation_code Database column
 * @property  integer preview_ready Database column
 * @property  string  facebook_user_id Database column
 * @property  string  facebook_token Database column
 * @property  string  password_salt Database column
 * @property  Author[] authors Relation
 * @property  Image[] images Relation
 * @property  Poem[] poems Relation
 * @property  Post[] posts Relation
 * @property  Recitation[] recitations Relation
 * @property  RecitationVote[] recitation_votes Relation
 * @property  UserSession[] user_sessions Relation
 */
abstract class UserBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  User  An instance of Model class
	 */
	public static function model($className = 'User')
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
		return 'user';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'authors' => array(self::HAS_MANY, 'Author', 'submitter_id'),
			'images' => array(self::HAS_MANY, 'Image', 'author_id'),
			'poems' => array(self::HAS_MANY, 'Poem', 'submitted_by'),
			'posts' => array(self::HAS_MANY, 'Post', 'author_id'),
			'recitations' => array(self::HAS_MANY, 'Recitation', 'performer_id'),
			'recitation_votes' => array(self::HAS_MANY, 'RecitationVote', 'voter_id'),
			'user_sessions' => array(self::HAS_MANY, 'UserSession', 'user_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  UserSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new UserSerializer($this);
	}
}
