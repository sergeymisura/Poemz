<?php
class Serialization extends CComponent
{
	public function init()
	{
	}

	public function serialize($data)
	{
		if (is_array($data))
		{
			$result = array();
			foreach ($data as $key => $value)
			{
				$result[$key] = $this->serialize($value);
			}
		}
		elseif ($data instanceof ISerializable)
		{
			$result = $data->getSerializer()->collectAttributes();
			foreach($result as $name => &$value)
			{
				$result[$name] = $this->serialize($value);
			}
		}
		else
		{
			$result = $data;
		}
		return $result;
	}
}
