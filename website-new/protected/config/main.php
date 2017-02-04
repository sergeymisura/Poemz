<?php
/**
 * Website configuration setting
 */

return CMap::mergeArray(
	CMap::mergeArray(
		array(

			'name' => 'Poemz.org',
			'runtimePath' => '/tmp',

			'preload' => array('log'),

			'components' => array(

				'urlManager' => array(
					'class' => 'UrlManager',
					'urlFormat'=>'path',
					'showScriptName' => false,
					'routeFile' => dirname(__FILE__).'/route.json',
				),

				'request' => array(
					'class' => 'HttpRequestExt',
				),

				'serialization' => array(
					'class' => 'Serialization'
				),
			),

			'params' => array(
				'auth_cookie' => 'poemz_new_auth',
				'origins' => array(
					'http://localhost:3000',
					'http://poemz-client-sergeymisura.c9users.io',
					'https://poemz-client-sergeymisura.c9users.io'
				),
			),

		),
		require_once(__DIR__ . DIRECTORY_SEPARATOR . 'common.php')
	),
	file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'local.php')
		? require_once(__DIR__ . DIRECTORY_SEPARATOR . 'local.php')
		: array()
);
