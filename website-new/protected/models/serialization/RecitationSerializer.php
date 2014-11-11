<?php
/**
 * Serializer class for Recitation model
 *
 * @package Regent.Common.Models.Base
 *
 */
class RecitationSerializer extends ModelSerializer
{
	/**
	 * Processes the collected attributes before they are serialized.
	 *
	 * @param   array  A reference to an array of attributes
	 *
	 * @return  void
	**/
	protected function process(&$attributes)
	{
		if(isset(Yii::app()->format))
		{
			$attributes['ago'] = Yii::app()->format->timeSince($attributes['created']);
		}
	}
}
