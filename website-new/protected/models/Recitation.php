<?php
/**
 * Base class for Recitation model
 *
 * @package Regent.Common.Models
 *
 */
class Recitation extends RecitationBase
{
	public function updateVotes()
	{
		$this->votes = RecitationVote::model()->countByAttributes(array('recitation_id' => $this->id));
		$this->save();
	}
}
