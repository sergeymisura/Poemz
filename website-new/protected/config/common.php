<?php
/**
 * Configuration options shared between the command line tool and the website
 */
return array(
	'timeZone' => 'America/New_York',

	'basePath' => __DIR__ . DIRECTORY_SEPARATOR . '..',

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
	),

	'params' => array(
		'database_timezone' => 'US/Eastern'
	)
);