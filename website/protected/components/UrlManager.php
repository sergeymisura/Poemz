<?php
/**
 * This extension to Yii url manager loads routes from JSON file
 *
 * @package  CanDo.Components
 */
class UrlManager extends CUrlManager
{
	/**
	 * @var  string  Name of the file with URL routing information
	 */
	public $routeFile;

	/**
	 * Initializes component
	 * 
	 * @see  CUrlManager::init()
	 * 
	 * @return  void
	 */
	public function init()
	{

		$resource_actions = array(
			'get' => array('GET', '/<id>'),
			'create' => array('POST', ''),
			'update' => array('POST', '/<id>')
		);

		$yii_routes = json_decode(file_get_contents($this->routeFile), true);
		if (!$yii_routes)
		{
			throw new Exception('routes.json is corrupted or missing.');
		}
		$yii_routes_filtered = array();
		foreach ($yii_routes as $pattern => &$route)
		{
			if (is_array($route))
			{
				$route[0] = $route['route'];
			}
			if (strpos($pattern, ':') > 0)
			{
				$pair = explode(':', $pattern);
				if (!is_array($route))
				{
					$route = array($route);
				}
				$route['pattern'] = $pair[1];
				if ($pair[0] == "RESOURCE")
				{
					foreach($resource_actions as $action => $options)
					{
						$r = $route;
						$r['verb'] = $options[0];
						$r['pattern'] .= $options[1];
						$r[0] .= '/' . $action;
						$yii_routes_filtered[] = $r;
					}
				}
				else
				{
					$route['verb'] = $pair[0];
					$yii_routes_filtered[] = $route;
				}
			}
			else
			{
				$yii_routes_filtered[$pattern] = $route;
			}
		}
		$this->rules = $yii_routes_filtered;
		parent::init();
	}
}
