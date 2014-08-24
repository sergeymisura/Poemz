<?php
/**
 * Base class for Poem model
 *
 * @package Regent.Common.Models
 *
 */
class Poem extends PoemBase
{
	function relations()
	{
		$relations = parent::relations();
		$relations['recitations_count'] = array(self::STAT, 'Recitation', 'poem_id');
		return $relations;
	}
}
