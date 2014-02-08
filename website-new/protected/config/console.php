<?php
/**
 * Console app configuration setting
 */

return CMap::mergeArray(
		CMap::mergeArray(
			array(

				// Console-specific settings will be added here

			),
			require_once(__DIR__ . DIRECTORY_SEPARATOR . 'common.php')
		),
		file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'local.php')
		? require_once(__DIR__ . DIRECTORY_SEPARATOR . 'local.php')
		: array()
);
