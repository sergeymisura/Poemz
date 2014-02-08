<?php
class ModelsCommand extends CConsoleCommand
{
	private $_options;

	public function actionGenerate()
	{
		$db = Yii::app()->db;
		$tables = $db->createCommand('show tables')->queryColumn();

		$options = require_once(__DIR__ . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'tuning.php');
		$this->_options = $options;

		$baseClassTemplate = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'base_class_template.txt');
		$modelClassTemplate = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'class_template.txt');
		$serializerClassTemplate = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'serializer_class_template.txt');

		$modelOutputPath = Yii::getPathOfAlias('common') . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR;
		$baseOutputPath = $modelOutputPath . 'base' . DIRECTORY_SEPARATOR;
		$serializerOutputPath = $modelOutputPath . 'serialization' . DIRECTORY_SEPARATOR;

		$entities = array();
		foreach ($tables as $table)
		{
			if (count($db->createCommand("show index from " . $table . " where Key_name = 'Primary'")->queryAll()) == 1)
			{
				$entities[$table] = array();
			}
		}

		foreach ($entities as $table => &$relations)
		{
			$foreignKeys = $db->createCommand()
				->select('table_name, column_name, referenced_table_name, referenced_column_name')
				->from('information_schema.key_column_usage')
				->where('referenced_table_name is not null and table_schema = schema() and table_name = :table')
				->queryAll(
					true,
					array(
						':table' => $table
					)
				);
			foreach ($foreignKeys as $key)
			{
				if (isset($entities[$key['referenced_table_name']]))
				{
					if (array_search($this->dbToCamel($table) . '.' . str_replace('_id', '', $key['column_name']), $options['ignore']) === false)
					{
						$relations[] = array(
							"\t\t\t'" . str_replace('_id', '', $key['column_name']) . "' => array(self::BELONGS_TO, '" . $this->dbToCamel($key['referenced_table_name']) . "', '" . $key['column_name'] . "')",
							" * @property  " . $this->dbToCamel($key['referenced_table_name']) . " " . str_replace('_id', '', $key['column_name']) . " Relation"
						);
					}

					$index = $db->createCommand("show index from " . $table . " where Key_name = 'Primary'")->queryRow(true);
					$has_one = $index['Column_name'] == $key['column_name'];
					$parentRelationName = isset($options['aliases'][$table . '.' . $key['column_name']]) ? $options['aliases'][$table . '.' . $key['column_name']] : $table . ($has_one ? '' : 's');

					if (array_search($this->dbToCamel($key['referenced_table_name']) . '.' . $parentRelationName, $options['ignore']) === false)
					{
						$entities[$key['referenced_table_name']][] = array(
							"\t\t\t'" . $parentRelationName . "' => array(self::" . ($has_one ? 'HAS_ONE' : 'HAS_MANY') . ", '" . $this->dbToCamel($table) . "', '" . $key['column_name'] . "')",
							" * @property  " . $this->dbToCamel($table) . ($has_one ? '' : '[]') . " " . $parentRelationName . " Relation"
						);
					}
				}
			}
		}

		foreach ($entities as $table => &$relations)
		{
			$className = $this->dbToCamel($table);
			$rel = array();
			$prop = array();
			foreach ($relations as $relation)
			{
				$rel[] = $relation[0];
				$prop[] = $relation[1];
			}
			$baseClass = $this->replaceValues(
				$baseClassTemplate,
				array(
					'name' => $className,
					'table' => $table,
					'relations' => implode(",\n", $rel),
					'properties' => implode("\n", array_merge($this->getProperties($table), $prop))
				)
			);
			file_put_contents($baseOutputPath . $className . 'Base.php', $baseClass);
			if (!file_exists($modelOutputPath . $className . '.php'))
			{
				$modelClass = $this->replaceValues(
					$modelClassTemplate,
					array(
						'name' => $className,
						'table' => $table
					)
				);
				file_put_contents($modelOutputPath . $className . '.php', $modelClass);
			}
			if (!file_exists($serializerOutputPath . $className . 'Serializer.php'))
			{
				$serializerClass = $this->replaceValues(
					$serializerClassTemplate,
					array(
						'name' => $className,
						'table' => $table
					)
				);
				file_put_contents($serializerOutputPath . $className . 'Serializer.php', $serializerClass);
			}
		}
	}

	private function replaceValues($template, $values)
	{
		foreach ($values as $name => $value)
		{
			$template = str_replace('{' . $name . '}', $value, $template);
		}
		return $template;
	}

	private function dbToCamel($name)
	{
		$result = '';
		foreach (explode('_', $name) as $word)
		{
			$result .= ucfirst($word);
		}
		return $result;
	}

	private function getProperties($table)
	{
		$data = Yii::app()->db->createCommand('show columns from ' . $table)->queryAll(true);
		$props = array();
		$class_name = $this->dbToCamel($table);
		foreach ($data as $column)
		{
			if (array_search($class_name . '.' . $column['Field'], $this->_options['ignore']) === false)
			{
				$type = 'mixed  ';
				if (strpos($column['Type'], 'int(') === 0)
				{
					$type = 'integer';
				}
				elseif (strpos($column['Type'], 'varchar(') === 0)
				{
					$type = 'string ';
				}
				elseif (strpos($column['Type'], 'text') === 0)
				{
					$type = 'string ';
				}
				elseif (strpos($column['Type'], 'tinyint(') === 0)
				{
					$type = 'boolean';
				}
				$props[] = ' * @property  ' . $type . ' ' . $column['Field'] . ' Database column';
			}
		}
		return $props;
	}
}
