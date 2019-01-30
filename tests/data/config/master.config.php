<?php 
/**
 * Copyright (c) 2015 SCHENCK Simon
 * 
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright     Copyright (c) SCHENCK Simon
 *
 */

/**
 * @codeCoverageIgnore
 */
return [
	'db' => [
		'MongoDB' =>[
			'host'=>'localhost',
			'port'=>'27017',
			'username'=>'',
			'password'=>'',
			'database'=>'skankyblogtest'
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
	'adminMail' => 'skankydev@skankydev.com',
];

