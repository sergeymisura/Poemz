<?php
/**
 * Configuration settings specific for the environment
 */
return array(
	'params' => array(
		'mode' => 'debug',
		'database_timezone' => '-05:00'
	),

	'components' => array(
		'db' => array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=poemz',
			'username' => 'root',
			'password' => '@Cand0.c0m',
		)
	)
);
