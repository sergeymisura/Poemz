<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Author instead.
 * Base class for Author model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  string  name Database column
 * @property  integer submitted_by Database column
 * @property  User submitted_by Relation
 * @property  AuthorFulltext[] author_fulltexts Relation
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
			'submitted_by' => array(self::BELONGS_TO, 'User', 'submitted_by'),
			'author_fulltexts' => array(self::HAS_MANY, 'AuthorFulltext', 'author_id'),
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
