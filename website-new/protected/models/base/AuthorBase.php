<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Author instead.
 * Base class for Author model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  string  name Database column
 * @property  integer submitter_id Database column
 * @property  integer avatar_id Database column
 * @property  string  slug Database column
 * @property  string  wiki_url Database column
 * @property  mixed   wiki_excerpt Database column
 * @property  integer avatar_original_id Database column
 * @property  Image avatar_original Relation
 * @property  User submitter Relation
 * @property  Image avatar Relation
 * @property  Poem[] poems Relation
 */
abstract class AuthorBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Author  An instance of Model class
	 */
	public static function model($className = 'Author')
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
		return 'author';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'avatar_original' => array(self::BELONGS_TO, 'Image', 'avatar_original_id'),
			'submitter' => array(self::BELONGS_TO, 'User', 'submitter_id'),
			'avatar' => array(self::BELONGS_TO, 'Image', 'avatar_id'),
			'poems' => array(self::HAS_MANY, 'Poem', 'author_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  AuthorSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new AuthorSerializer($this);
	}
}
