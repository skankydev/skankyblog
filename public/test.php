<?php
require '../vendor/autoload.php';

use SkankyDev\Config\Config;
use SkankyDev\Routing\Route\Route;
use SkankyDev\Routing\Router;
use SkankyDev\Routing\UrlBuilder;

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
	Config::set('default.action','index');
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
	Router::_add('/article/:slug',[
		'controller' => 'Post',
		'action'     => 'view',
	],[
		'slug'=> '[a-zA-Z0-9\-]*'
	]);
	Router::_findCurrentRoute('/article/youpi-test');
	//debug(Router::_findCurrentRoute('/post/list'));
	echo UrlBuilder::_build(['controller'=>'Post','action'=>'view','params'=>['youpi-test'],'get'=>['page'=>1,'order'=>'field']]);
	echo "<br>";
	echo UrlBuilder::_build(['controller'=>'Message','action'=>'view','params'=>['youpi-test']]);
?>

</body>
</html>
