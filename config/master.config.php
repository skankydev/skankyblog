<?php 
/**
 * congratulation you have found the master configuration file
 */
$conf =  [
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
	'smtp' => require 'smtp.config.php',
	'debug' => 2,
];
return $conf;

/*
smtp.config.php exemple
return [
	'default' => [
		'host' => '***',
		'username' => '***',
		'password' => '***',
		'secure' => 'ssl',
		'port' => '465',
		'sender' => 'no-reply@skankydev.com'
	]
];

 */