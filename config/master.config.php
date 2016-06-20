<?php 
/**
 * congratulation you have found the master configuration file
 */
return [
	'db' => [
		'MongoDB' =>[
			'host'=>'localhost',
			'port'=>'27017',
			'username'=>'',
			'password'=>'',
			'database'=>'skankydev'
		]
	],
	'Module'=>[
		'App'
	],
	'location'=>[
		'fr'=>[
			'domaine'=>'App',
			'langue' =>'fr_FR'
		],
		'en'=>[
			'domaine'=>'App',
			'langue' =>'en_EN'
		],
	],
	'debug' => 2,
];
