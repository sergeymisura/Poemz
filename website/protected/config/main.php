<?php
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',

	// project theme
	//'theme'=>'qurate',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
			'application.models.*',
			'application.components.*',
			'application.components.security.*',
			'application.reports.*'
	),

	// application components
	'components'=>array(
		'http' => array(
			'class' => 'Http'
		),
		'format' => array(
			'class' => 'Formatter',
			'numberFormat' => array(
				'decimals' => 2,
				'decimalSeparator' => '.',
				'thousandSeparator' => ',',
			)
		),

		'request' => array(
			'class' => 'HttpRequest'
		),

		'facebook' => array(                   	// Facebook App credentials
			'class' => 'FacebookComponent',
			'appId' => '',
			'secretKey' => '',
			'namespace' => ''
		),

		'sendgrid' => array(
			'class'		=> 'SendGridComponent',
			'user'		=> '',
			'key'		=> '',
			'from'		=> ''
		),

		'urlManager'=>array(
			'class' => 'UrlManager',
			'urlFormat'=>'path',
			'showScriptName' => false,
			'routeFile' => dirname(__FILE__).'/route.json'
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            //'errorAction'=>'site/error',
        ),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'mode' => 'live'
	),
);