<?php 
use SkankyDev\Routing\Router;


Router::_add('/',[
	'controller' => 'Home',
	'action'     => 'index',
	'namespace'  => 'App'
]);