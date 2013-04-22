<?php

return array(
	'runtimePath' => '/var/runtime/politics',
	'components' => array(
		'db' => array(
				'class' => 'CDbConnection',
				'connectionString' => 'mysql:host=localhost;dbname=poemz',
				'username' => 'root',
				'password' => '@Cand0.c0m'
		)
	),
	'params' => array(
		'mode' => 'debug'
	)
);

