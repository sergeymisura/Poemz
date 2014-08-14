<?php
/**
 * WARNING: This is an automatically generated file. Do not modify it, use RecitationData instead.
 * Base class for RecitationData model
 *
 * @package Regent.Common.Models.Base
 *
 * @property  integer recitation_id Database column
 * @property  mixed   data Database column
 * @property  Recitation recitation Relation
 */
abstract class RecitationDataBase extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  RecitationData  An instance of Model class
	 */
	public static function model($className = 'RecitationData')
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
		return 'recitation_data';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
			'recitation' => array(self::BELONGS_TO, 'Recitation', 'recitation_id')
		);
	}

	/**
	 * Returns the model's serializer
	 *
	 * @return  RecitationDataSerializer  An instance of the model serializer
	 */
	public function getSerializer()
	{
		return new RecitationDataSerializer($this);
	}
}
