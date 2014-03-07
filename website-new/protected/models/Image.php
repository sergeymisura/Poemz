<?php
/**
 * Base class for Image model
 *
 * @package Regent.Common.Models
 *
 * @property  string  $url
 */
class Image extends ImageBase
{
	public function getUrl() {
		return Yii::app()->createUrl('images/index', array('image_id' => $this->id));
	}
}
