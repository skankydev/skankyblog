<?php 
/**
 * congratulation you have found the master configuration file
 */
$smtp = require 'smtp.config.php';
$conf =  [
	'db' => [
		'MongoDB' =>[
			'host'=>'localhost',
			'port'=>'27017',
			'username'=>'',
			'password'=>'',
			'database'=>'skankyblog'
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
	'smtp' => $smtp,
	'debug' => 2,
	'adminMail' => 'skankydev@gmail.com',
	
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
		'sender' => 'no-reply@mail.com'
	]
];

smtp.config.php exemple
return [
	
];

 */