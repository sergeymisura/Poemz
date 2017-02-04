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

	static public function slugify($text, $prefix='word')
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\\pL\d]+~u', '-', $text);

		// trim
		$text = trim($text, '-');

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// lowercase
		$text = strtolower($text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		if (empty($text))
		{
			return $prefix . '-' . rand(99999, 100000);
		}

		if (preg_match('/^[0-9]+$/', $text)) {
			return $prefix . '-' . $text;
		}

		return $text;
	}
}
