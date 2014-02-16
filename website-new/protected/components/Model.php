<?php
/**
 * Extending functionality of Yii Active Record
 *
 * @package  CanDo.Components
 */
abstract class Model extends CActiveRecord implements ISerializable
{
	/**
	 * Returns the current date in mysql-compatible format (YYYY-MM-DD)
	 *
	 * @param   int  $value  Unix timestamp
	 *
	 * @return  string  Date in YYYY-MM-DD format
	 */
	public static function getDbDate($value = null, $include_time = false)
	{
		if ($value === null)
		{
			$value = time();
		}
		return date('Y-m-d' . ($include_time ? ' H:i:s' : ''), $value);
	}

	abstract public function getSerializer();
}
