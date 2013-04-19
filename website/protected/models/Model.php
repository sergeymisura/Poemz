<?php
/**
 * Extension for Yii CActiveRecord that allows to automatically prepare object to be send back by AJAX call
 * 
 * @package  CanDo.Models
 */
class Model extends CActiveRecord
{
	/**
	 * @var  array  A list of attributes that should be sent to the client even if they are normally hidden.
	 */
	private $_unhide = array();

	/**
	 * @var  array  A list of fields that needs to be calculated
	 */
	private $_calculated = array();

	/**
	 * Overrides the constructor to get the list of calculated fields
	 * 
	 * @param   string  $scenario  Active record scenario
	 */
	public function __construct($scenario='insert')
	{
		parent::__construct($scenario);
		$this->_calculated = $this->calculated();
	}

	/**
	 * Provides a list of attributes that should not be send to the browser by Ajax call.
	 * 
	 * @return  array  A list of attribute names
	 */
	public function hidden()
	{
		return array();
	}

	/**
	 * Allows to explicitly specify a list of attributes that are normally hidden, but should be sent this time.
	 * 
	 * @param   array  $names  A list of attribute names
	 * 
	 * @return  Model  A reference to the same object to allow chained calls.
	 */
	public function unhide($names)
	{
		$this->_unhide = array_merge($this->_unhide, is_array($names) ? $names : array($names));
		return $this;
	}

	/**
	 * Returns a list of the fields that needs to be calculated and their dependencies on the database fields
	 *
	 * @return  array  List of the fields that needs to be calculated
	 */
	public function calculated()
	{
		return array();
	}

	/**
	 * This method is called when the calculated field needs to be re-calculated
	 * 
	 * @param   string  $name  Name of the field
	 * 
	 * @return  mixed  New value for the field
	 */
	public function calculate($name)
	{
	}

	/**
	 * Overrides CActiveRecord::setAttribute to calculate dependent fields when needed
	 * 
	 * @param   string  $name   The attribute name
	 * @param   mixed   $value  The attribute value
	 * 
	 * @return  boolean  Whether the attribute exists and the assignment is conducted successfully
	 */
	public function setAttribute($name, $value)
	{
		if (parent::setAttribute($name, $value))
		{
			foreach ($this->_calculated as $field => $sources)
			{
				$calculate = false;
				if (is_array($sources))
				{
					$calculate = array_search($name, $sources) !== false;
				}
				else
				{
					$calculate = $name === $sources;
				}
				if ($calculate)
				{
					$this->$field = $this->calculate($field);
				}
			}
			return true;
		}
		return false;
	}

	/**
	 * Prepares data for AJAX call. Usually used by ApiController::prepare.
	 * 
	 * @return  array  Data that should be sent back to the browser
	 */
	public function export()
	{
		// First, get all attributes
		$attributes = $this->attributes;

		// Then get all calculated public properties
		foreach (get_object_vars($this) as $name => $value)
		{
			if ($name[0] != '_')
			{
				$attributes[$name] = $value;
			}
		}

		// Second, get all relations that are already loaded
		foreach ($this->metaData->relations as $name => $relation)
		{
			if ($this->hasRelated($name))
			{
				$attributes[$name] = $this->$name;
			}
		}

		// Third, hide the attributes that we don't want to expose to the client
		foreach (array_diff($this->hidden(), $this->_unhide) as $name)
		{
			if (array_key_exists($name, $attributes))
			{
				unset($attributes[$name]);
			}
		}

		return $attributes;
	}

	/**
	 * Uses parent's populateRecord to do the job and then passes list of 'unhidden' attributes to the newly created object. 
	 *
	 * @param   array    $attributes     See CActiveRecord description
	 * @param   boolean  $callAfterFind  See CActiveRecord description
	 * 
	 * @return  CActiveRecord  An instance of the model class
	 *
	 * @see CActiveRecord::populateRecord()
	 */
	public function populateRecord($attributes, $callAfterFind=true)
	{
		$record = parent::populateRecord($attributes, $callAfterFind);
		if ($record === null)
		{
			return null;
		}
		$record->_unhide = $this->_unhide;
		foreach ($this->_calculated as $field => $sources)
		{
			$record->$field = $record->calculate($field);
		}
		return $record;
	}

	/**
	 * Returns the date and time (current or for given timestamp) in the format that is accepted by the database.
	 * 
	 * @param   int  $time  Timestamp to format, null for current date and time
	 * 
	 * @return  string  Formatted date and time
	 */
	public static function getDbDate($time=null)
	{
		if ($time === null)
		{
			$time = time();
		}
		return date('Y-m-d H:i:s', $time);
	}
}
