<?php
/**
 * Serializer class for Image model
 *
 * @package Regent.Common.Models.Base
 *
 */
class ImageSerializer extends ModelSerializer
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
		unset($attributes['content']);
	}
}
