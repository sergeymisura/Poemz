<?php
/**
 * Base class for Topic model
 *
 * @package Regent.Common.Models
 *
 * @param  int  comments_count
 */
class Topic extends TopicBase
{
	public function relations()
	{
		$relations = parent::relations();
		$relations['comments_count'] = array(self::STAT, 'Post', 'topic_id');
		return $relations;
	}
}
