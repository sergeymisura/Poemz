<?php
abstract class ModelSerializer
{
	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function collectAttributes()
	{
		$attributes = $this->model->getAttributes();
		foreach ($this->model->metaData->relations as $name => $relation)
		{
			if ($this->model->hasRelated($name))
			{
				$attributes[$name] = $this->model->$name;
			}
		}
		$this->process($attributes);
		return $attributes;
	}

	protected abstract function process(&$attributes);
}
