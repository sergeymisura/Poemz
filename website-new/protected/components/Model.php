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
	 * @param   int  $time  Unix timestamp
	 *
	 * @return  string  Date in YYYY-MM-DD format
	 */
	public static function getDbDate($time = null)
	{
		if ($time === null)
		{
			$time = time();
		}
		return date('Y-m-d', $time);
	}

	abstract public function getSerializer();
}
