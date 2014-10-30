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
 * @property  string  password_salt Database column
 * @property  mixed   about Database column
 * @property  string  website Database column
 * @property  integer avatar_id Database column
 * @property  string  slug Database column
 * @property  Author[] authors Relation
 * @property  Identity[] identities Relation
 * @property  Image[] images Relation
 * @property  Poem[] poems Relation
 * @property  Post[] posts Relation
 * @property  Recitation[] recitations Relation
 * @property  RecitationVote[] recitation_votes Relation
 * @property  Image avatar Relation
 * @property  UserRole[] user_roles Relation
 * @property  UserSession[] user_sessions Relation
 * @property  Visitor[] visitors Relation
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
			'identities' => array(self::HAS_MANY, 'Identity', 'user_id'),
			'images' => array(self::HAS_MANY, 'Image', 'author_id'),
			'poems' => array(self::HAS_MANY, 'Poem', 'submitted_by'),
			'posts' => array(self::HAS_MANY, 'Post', 'author_id'),
			'recitations' => array(self::HAS_MANY, 'Recitation', 'performer_id'),
			'recitation_votes' => array(self::HAS_MANY, 'RecitationVote', 'voter_id'),
			'avatar' => array(self::BELONGS_TO, 'Image', 'avatar_id'),
			'user_roles' => array(self::HAS_MANY, 'UserRole', 'user_id'),
			'user_sessions' => array(self::HAS_MANY, 'UserSession', 'user_id'),
			'visitors' => array(self::HAS_MANY, 'Visitor', 'user_id')
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
