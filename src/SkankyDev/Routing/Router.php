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

namespace SkankyDev\Routing;

use SkankyDev\Request;
use SkankyDev\Routing\Route\CurrentRoute;
use SkankyDev\Routing\Route\Route;
use SkankyDev\Utilities\Traits\Singleton;


class Router
{
	use Singleton;

	//private $request;
	private $routesCollection;
	private $current = false;

	public function __construct(){
		$this->routes = [];
	}

	public function add($scope,$link,$rules = []){
		$this->routesCollection[] =  new Route($scope,$link,$rules);
	}

	public function getRoutesCollection(){
		return $this->routesCollection;
	}

	public function getCurrentRoute(){
		return $this->current;
	}

	public function findCurrentRoute(string $uri){
		$tmp = explode('?', $uri);
		$uri = $tmp[0];
		$route = $this->matchRouteUri($uri);
		$this->current = new CurrentRoute($uri,$route);
		return $this->current;
	}

	public function matchRouteUri(string $uri){

		foreach ($this->routesCollection as $route) {
			$regex = $route->getMatcheRules();
			if(preg_match($regex,$uri)){
				return $route;
			}
		}
		return null;
	}
}