<?php

return [

	'crypt' => 'xcrypt',

	'default' => [

		'login' => 'simple',

		'group' => 'simple',

		'acl' => 'simple',
	],

	//'loginField' => 'username',
	'loginField' => ['username', 'email'],
];