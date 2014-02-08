<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use AuthorFulltext instead.
 * Base class for AuthorFulltext model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  string  word Database column
 * @property  integer author_id Database column
 * @property  integer weight Database column
 * @property  Author author Relation
 */
abstract class AuthorFulltextBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  AuthorFulltext  An instance of Model class
	 */
	public static function model($className = 'AuthorFulltext')
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
		return 'author_fulltext';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'author' => array(self::BELONGS_TO, 'Author', 'author_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  AuthorFulltextSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new AuthorFulltextSerializer($this);
	}
}
