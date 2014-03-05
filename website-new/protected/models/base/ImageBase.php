<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use Image instead.
 * Base class for Image model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer id Database column
 * @property  integer author_id Database column
 * @property  mixed   content Database column
 * @property  Author[] authors Relation
 * @property  User author Relation
 */
abstract class ImageBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  Image  An instance of Model class
	 */
	public static function model($className = 'Image')
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
		return 'image';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'authors' => array(self::HAS_MANY, 'Author', 'avatar_id'),
			'author' => array(self::BELONGS_TO, 'User', 'author_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  ImageSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new ImageSerializer($this);
	}
}
