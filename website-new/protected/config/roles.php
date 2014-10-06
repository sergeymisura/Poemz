<?php
return [
	'permissions' => [
		'poem:edit',
		'recitation:delete'
	],
	'roles' => [
		['admin', [ 'poem:edit', 'recitation:delete' ]],
		['editor', [ 'poem:edit' ]],
	]
];
