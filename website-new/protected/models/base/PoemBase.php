<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Poem instead.
 * Base class for Poem model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  string  title Database column
 * @property  integer author_id Database column
 * @property  integer submitted_by Database column
 * @property  mixed   text Database column
 * @property  string  first_line Database column
 * @property  string  slug Database column
 * @property  integer topic_id Database column
 * @property  Topic topic Relation
 * @property  User submitted_by Relation
 * @property  Author author Relation
 * @property  Recitation[] recitations Relation
 */
abstract class PoemBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Poem  An instance of Model class
	 */
	public static function model($className = 'Poem')
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
		return 'poem';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'topic' => array(self::BELONGS_TO, 'Topic', 'topic_id'),
			'submitted_by' => array(self::BELONGS_TO, 'User', 'submitted_by'),
			'author' => array(self::BELONGS_TO, 'Author', 'author_id'),
			'recitations' => array(self::HAS_MANY, 'Recitation', 'poem_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  PoemSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new PoemSerializer($this);
	}
}
