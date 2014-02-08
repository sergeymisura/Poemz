<?php
session_start();
date_default_timezone_set("America/Los_Angeles");
ini_set("memory_limit","512M");
// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$configMain=dirname(__FILE__).'/protected/config/main.php';
//$configLocal=dirname(__FILE__).'/protected/config/local.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

$config = require $configMain;

/*if(file_exists($configLocal)) {
	$config = CMap::mergeArray($config, require $configLocal);
}*/

CMap::mergeArray(
	$config,
	array(
		'components' => array(
			'request' => array(
				'baseUrl' => str_replace('/index.php', '', $_SERVER['SCRIPT_NAME'])
			)
		)
	)
);

Yii::createWebApplication($config)->run();
