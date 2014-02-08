<?php
abstract class ModelSerializer
{
	private $_model;

	public function __construct(Model $model)
	{
		$this->_model = $model;
	}

	public function collectAttributes()
	{
		$attributes = $this->_model->getAttributes();
		foreach ($this->_model->metaData->relations as $name => $relation)
		{
			if ($this->_model->hasRelated($name))
			{
				$attributes[$name] = $this->_model->$name;
			}
		}
		$this->process($attributes);
		return $attributes;
	}

	protected abstract function process(&$attributes);
}
