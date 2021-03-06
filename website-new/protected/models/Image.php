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

	public function square($size = null) {
		$image = imagecreatefromstring($this->content);
		$width = imagesx($image);
		$height = imagesy($image);

		if ($size == null)
		{
			$size = min($width, $height);
		}

		$new = imagecreatetruecolor($size, $size);
		imagecopyresampled($new, $image, 0, 0, 0, 0, $size, $size, min($width, $height), min($width, $height));

		ob_start();
		imagejpeg($new);

		$new_image = new Image;
		$new_image->author_id = $this->author_id;
		$new_image->content = ob_get_clean();
		$new_image->save();

		return $new_image;
	}
}
