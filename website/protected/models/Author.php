<?php
/**
 * User Model class
 * 
 * @package  Poemz.Models
 */
class Author extends Model
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
		return 'author';
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
		if (parent::save())
		{
			AuthorFullText::model()->deleteAllByAttributes(array('author_id' => $this->id));
			$matches = array();
			$line = strtolower($this->name);
			if (preg_match_all("/[a-z']+/", $line, $matches))
			{
				$existing = array();
				foreach ($matches[0] as $match)
				{
					if (!isset($existing[$match]))
					{
						$existing[$match] = true;
						$ft = new AuthorFullText();
						$ft->author_id = $this->id;
						$ft->word = $match;
						$ft->save();
					}
				}
			}
			die();
			return true;
		}
		return false;
	}
}
