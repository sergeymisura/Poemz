<?php

return array(
	'runtimePath' => '/var/runtime/politics',
	'components' => array(
		'db' => array(
				'class' => 'CDbConnection',
				'connectionString' => 'mysql:host=;dbname=',
				'username' => '',
				'password' => ''
		)
	),
	'params' => array(
		'mode' => 'debug'
	)
);

