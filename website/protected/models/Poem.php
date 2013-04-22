<?php
/**
 * User Model class
 * 
 * @package  Poemz.Models
 */
class Poem extends Model
{
	/**
	 * Returns an instance of the model class
	 *
	 * @param   string  $className  Name of the class
	 *
	 * @return  User  An instance of Model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Returns the name of the table
	 *
	 * @return  string  Name of the database table
	 */
	public function tableName()
	{
		return 'poem';
	}

	/**
	 * Returns the list of relations of this model class
	 *
	 * @return  array  A list of relations to other classes in the data model
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * Returns a list of attributes that we don't want to send in API response by default
	 * 
	 * @return  array  A list of attributes to hide
	 */
	public function hidden()
	{
		return array();
	}

	public function save()
	{
		$line_end = strpos($this->text, "\n");
		if ($line_end === false)
		{
			$line_end = strlen($this->text);
		}
		$this->first_line = rtrim(trim(substr($this->text, 0, $line_end)), '.,') . '...';

		if (parent::save())
		{
			PoemFullText::model()->deleteAllByAttributes(array('poem_id' => $this->id));
			foreach (array($this->title, $this->first_line) as $string)
			{
				$line = strtolower($string);
				$matches = array();
				if (preg_match_all("/[a-z0-9']+/", $line, $matches))
				{
					$existing = array();
					$first = true;
					foreach ($matches[0] as $match)
					{
						if (!isset($existing[$match]))
						{
							$existing[$match] = true;
							$ft = new PoemFullText();
							$ft->poem_id = $this->id;
							$ft->word = $match;
							$ft->weight = $first ? 10 : 1;
							$ft->save();
							$first = false;
						}
					}
				}
			}
			return true;
		}
		return false;
	}
}
