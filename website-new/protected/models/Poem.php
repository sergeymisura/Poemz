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
		$command = Yii::app()->db->createCommand()
			->selectDistinct('poem_id')
			->from('recitation')
			->order('votes desc')
			->limit($limit)
			->offset($offset);

		$result = array();
		foreach ($command->query() as $row)
		{
			$result[] = Poem::model()->with('author')->findByPk($row['poem_id']);
		}

		return $result;
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

		$result = array();
		foreach ($command->query() as $row)
		{
			$result[] = Poem::model()->with('author')->findByPk($row['poem_id']);
		}

		return $result;
	}

	public static function random($limit=6)
	{
		$result = array();
		$offsets = array();

		$total = Yii::app()->db->createCommand()
			->select('count(distinct poem_id)')
			->from('recitation')
			->queryScalar();

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
						'offset' => $new_offset,
						'condition' => 't.id in (select poem_id from recitation)'
					)
				);
			}
		}

		return $result;
	}

	/**
	 * @param   Poem[]  $list
	 *
	 * @return  array  An associative array with poem id as keys and top 2 recitations as values
	 */
	public static function topRecitations($list)
	{
		$recitations = array();
		foreach ($list as $poem)
		{
			$recitations[$poem->id] = $poem->getRelated('recitations', true, array('order' => 'votes desc', 'limit' => 2, 'with' => 'performer'));
		}
		return $recitations;
	}
}
