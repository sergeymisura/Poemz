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

	public static function best($offset=0, $limit=6)
	{
		return self::random($limit);
	}

	public static function favorite($user, $offset=0, $limit=6)
	{
		return self::random($limit);
	}

	public static function newest($offset=0, $limit=6)
	{
		$command = Yii::app()->db->createCommand()
			->selectDistinct('poem_id')
			->from('recitation')
			->order('id desc')
			->limit($limit)
			->offset($offset);

		$ids = $command->queryColumn();

		return Poem::model()->with('author')->findAll('t.id in (' . implode(',', $ids) . ')');
	}

	public static function random($limit=6)
	{
		$result = array();
		$offsets = array();

		$total = Poem::model()->count();

		while (count($offsets) < min($limit, $total))
		{
			$new_offset = rand(0, $total - 1);
			if (!in_array($new_offset, $offsets))
			{
				$offsets[] = $new_offset;
				$result[] = Poem::model()->with('author')->find(
					array(
						'order' => 't.id',
						'limit' => 1,
						'offset' => $new_offset
					)
				);
			}
		}

		return $result;
	}
}
