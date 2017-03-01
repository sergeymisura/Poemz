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
					'https://poemz-client-sergeymisura.c9users.io',
					'http://poemz-org-v2.herokuapp.com',
					'https://poemz-org-v2.herokuapp.com',
					'http://v2.poemz.org',
					'https://v2.poemz.org',
				),
			),

		),
		require_once(__DIR__ . DIRECTORY_SEPARATOR . 'common.php')
	),
	file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'local.php')
		? require_once(__DIR__ . DIRECTORY_SEPARATOR . 'local.php')
		: array()
);
