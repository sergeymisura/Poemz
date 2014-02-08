<?php
/**
 * Adds some formatters to Yii CFormatter class
 *
 * @package  CanDo.Components
 */
class Formatter extends CFormatter
{
	/**
	 * Returns the string that says how much time ago was the specified date
	 *
	 * @param   mixed  $value  Date - either string representation or integer value
	 *
	 * @return  string  Time between now and the given date
	 */
	public function formatTimeSince($value, $use_db_timestamp=true)
	{
		if ($value === null)
		{
			return null;
		}

		if (is_string($value))
		{
			$value = strtotime($value);
		}

		$post = 'ago';

		if ($use_db_timestamp)
		{
			$now = strtotime(Yii::app()->db->createCommand('select current_timestamp')->queryScalar());
		}
		else
		{
			$now = time();
		}

		$timeSince = $now - $value;
		if ($timeSince < 0)
		{
			$timeSince = -$timeSince;
			$post = 'left';
		}
		if ($timeSince < 10)
		{
			return 'Few seconds ' . $post;
		}

		$options = array(
			array(1, 60, 'second'),
			array(60, 60, 'minute'),
			array(3600, 24, 'hour'),
			array(3600 * 24, 7, 'day'),
			array(3600 * 24, 30, 'week'),
			array(3600 * 24 * 30, 365, 'month')
		);

		$text = null;
		foreach ($options as $option)
		{
			if ($timeSince / $option[0] < $option[1])
			{
				$value = floor($timeSince / $option[0]);
				$text = $option[2];
				break;
			}
		}

		if ($text === null)
		{
			$text = 'year';
			$value = floor($timeSince / 3600 * 24 * 365);
		}

		if ($value != 1)
		{
			$text .= 's';
		}

		return $value . ' ' . $text . ' ' . $post;
	}
}
