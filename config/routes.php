<?php 
use SkankyDev\Routing\Router;


Router::_add('/',[
	'controller' => 'Home',
	'action'     => 'index',
	'namespace'  => 'App'
]);

Router::_add('/articles',[
	'controller' => 'Post',
	'action'     => 'index',
	'namespace'  => 'App'
]);

Router::_add('/article/:slug',[
	'controller' => 'Post',
	'action'     => 'view',
	'namespace'  => 'App'
],[
	'slug' => '[a-z0-9-]*'
]);
