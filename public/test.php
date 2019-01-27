<?php
require '../vendor/autoload.php';

use SkankyDev\Config\Config;
use SkankyDev\Routing\Route\Route;
use SkankyDev\Routing\Router;

header('X-Frame-Options: DENY');//Clickjacking protection

define('DS',DIRECTORY_SEPARATOR); //séparateurs de dossier.
define('PUBLIC_FOLDER',dirname(__FILE__));//dossier public
define('APP_FOLDER', dirname(PUBLIC_FOLDER));//dossier de l'application

mb_internal_encoding("UTF-8");	//defini encodage des carataire utf-8


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="/css/app.css">
</head>
<body>
<?php 
	Config::set('default.namespace','App');
	Config::set('debug',2);
	Config::set('Module',['App']);
	/*$route = new Route('/:slug/:id',[
		'controller' => 'post',
		'action'     => 'view',
		'params'     => [
			'slug',
			'id'
		]
	],[
		'slug'=>'[a-zA-Z0-9\-]*',
		'id'=>'[0-9]*'
	]);*/
/*	Router::_add('/',[
		'controller' => 'Home',
		'action'     => 'index',
	],[
		'slug'=>'[a-zA-Z0-9\-]*',
	]);*/
	Router::_add('/:lang/article/:slug/:id',[
		'controller' => 'post',
		'action'     => 'view',
		'params'     => [
			'lang',
			'slug',
			'id'
		]
	],[
		'lang'=> '[a-z]{2}',
		'slug'=> '[a-zA-Z0-9\-]*',
		'id'  => '[0-9]*'
	]);
	debug(Router::_findCurrentRoute('/fr/article/youpi-test/1'));
	//debug(Router::_findCurrentRoute('/post/list'));
?>
</body>
</html>
