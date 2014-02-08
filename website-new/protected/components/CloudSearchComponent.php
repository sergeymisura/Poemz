<?php
/**
 * CloudSearch Integration
 *
 * @package  CanDo.Components
 *
 */
class CloudSearchComponent
{
	/**
	 * @var  string  $submit_url  CloudSearch URL
	 */
	public $submit_url = null;

	/**
	 * @var  string  $search_url  CloudSearch URL
	 */
	public $search_url = null;

	/**
	 * Initializes the component
	 *
	 * @return  void
	 */
	public function init()
	{
	}

	/**
	 * Adds or updates the document
	 *
	 * @param   ICloudSearchable  $object
	 *
	 * @return  void
	 */
	public function add(ICloudSearchable $object)
	{
		if ($this->submit_url == null)
		{
			return;
		}
		$type = get_class($object);
		$fields = $object->getCloudSearchFields();
		$fields['type'] = $type;
		$fields['id'] = $object->getCloudSearchId();

		$data = array(
			'type' => 'add',
			'id' => strtolower($type) . $fields['id'],
			'lang' => 'en',
			'fields' => &$fields
		);

		$version = Yii::app()->db
			->createCommand('select version from cloud_search_request where object_type = :type and object_id = :id')
			->queryScalar(array(':type' => $type, ':id' => $fields['id']));

		if ($version == null)
		{
			$version = 0;
		}
		$version = $version + 1;

		$data['version'] = $version;

		Yii::app()->db
			->createCommand('replace into cloud_search_request (object_id, object_type, version, document, lock_id, locked) values
																(:id, :type, :version, :data, null, null)')
			->execute(
				array(
					':type' => $type,
					':id' => $fields['id'],
					':version' => $version,
					':data' => json_encode($data)
				)
			);
	}

	public function delete(ICloudSearchable $object)
	{
		if ($this->submit_url == null)
		{
			return;
		}
		$type = get_class($object);
		$id = $object->getCloudSearchId();

		$data = array(
			'type' => 'delete',
			'id' => strtolower($type) . $id
		);

		$version = Yii::app()->db
			->createCommand('select version from cloud_search_request where object_type = :type and object_id = :id')
			->queryScalar(array(':type' => $type, ':id' => $id));

		if ($version == null)
		{
			$version = 0;
		}
		$version = $version + 1;

		$data['version'] = $version;

		Yii::app()->db
			->createCommand('replace into cloud_search_request (object_id, object_type, version, document, lock_id, locked) values
																(:id, :type, :version, :data, null, null)')
			->execute(
				array(
					':type' => $type,
					':id' => $id,
					':version' => $version,
					':data' => json_encode($data)
				)
			);

	}

	public function push($verbose = false)
	{
		if ($this->submit_url == null)
		{
			return;
		}

		Yii::app()->db->createCommand('update cloud_search_request set lock_id = null, locked = null where locked < adddate(now(), interval -1 hour)')->execute();

		$lock_id = sha1(time() . rand(0, 9999999));
		Yii::app()->db->createCommand('update cloud_search_request set lock_id = :id, locked = now() where document is not null and lock_id is null')->execute(array(':id' => $lock_id));

		$documents = Yii::app()->db->createCommand('select document from cloud_search_request where document is not null and lock_id = :id')->queryColumn(array(':id' => $lock_id));
		if (count($documents) == 0)
		{
			return;
		}

		$data = '[' . implode(', ', $documents) . ']';


		try
		{
			$response = Yii::app()->http->post(
				$this->submit_url,
				$data,
				true
			);

			if ($verbose)
			{
				var_dump($response);
			}

			Yii::app()->db->createCommand('update cloud_search_request set lock_id = null, locked = null, document = null where lock_id = :id')->execute(array(':id' => $lock_id));
		}
		catch (HttpCurlException $ex)
		{
			Issue::report(
				'php.integration.cloudsearch', 'medium', 'CloudSearch push failed', $ex->response->data()
			);
			if ($verbose)
			{
				var_dump($ex->response);
			}
		}
	}

	public function search($q, $end_user_only, $start = 0)
	{
		if ($this->search_url == null)
		{
			return null;
		}

		$request = array(
			'q' => $q,
			'start' => $start,
			'return-fields' => 'id,type,display,image_url'
		);

		if ($end_user_only)
		{
			$request['bq'] = 'user_searchable:1';
		}

		try
		{
			$response = Yii::app()->http->get(
				$this->search_url,
				$request
			);
			return new CloudSearchResults(json_decode($response->data(), true));
		}
		catch (HttpCurlException $ex)
		{
			return null;
		}
	}
}

class CloudSearchResults
{
	public $start;
	public $found;
	public $records = array();

	public function __construct($data)
	{
		$this->start = $data['hits']['start'];
		$this->found = $data['hits']['found'];
		foreach ($data['hits']['hit'] as $record)
		{
			$record_obj = new stdClass;
			foreach ($record['data'] as $name => $value_array)
			{
				$record_obj->$name = isset($value_array[0]) ? $value_array[0] : null;
			}
			$this->records[] = $record_obj;
		}
	}
}
