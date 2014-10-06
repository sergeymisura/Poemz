<?php
/**
 * Configuration options shared between the command line tool and the website
 */
return array(
	'timeZone' => 'America/New_York',

	'basePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',

	'import' => array(
		'application.components.*',
		'application.models.*',
		'application.models.base.*',
		'application.models.serialization.*'
	),

	'components' => array(
		'format' => array(
			'class' => 'Formatter'
		),

		'clientScript' => array(
			'class' => 'ClientScript'
		),

		/*'errorHandler' => array(
			'class'			=> 'ErrorHandler',
			'errorAction'	=> 'site/error',
			'source'		=> 'backend'
		),*/

		'http' => array(
			'class'		=> 'Http'
		),

		'access' => array(
			'class'		=> 'AccessComponent'
		),
	),

	'params' => array(
		'database_timezone' => 'US/Eastern'
	)
);
