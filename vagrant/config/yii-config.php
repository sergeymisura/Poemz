<?php
return [
	'components' => [
		'db' => [
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=poemz',
			'username' => 'poemz',
			'password' => 'devdb'
		]
	],
	'params' => [
		'mode' => 'debug',
		'database_timezone' => null,
		'fb_app_id' => '565093053580288'
	]
];
