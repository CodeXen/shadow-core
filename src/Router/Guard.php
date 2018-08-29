<?php 

namespace Shadow\Router;

class Guard 
{
	public $middlewares = [
		'web' => 'WebMiddleware@init',
		'cors' => 'CorsMiddleware@init',
	];

	public $router = null;

	function __construct($router) {
		$this->router = $router;
		$this->dispatch();
	}

	public function dispatch() {
		$middlewares = array('route' => '', 'before' => [], 'after' => []);
		foreach($this->middlewares as $key => $middleware) {
			$this->router->middleware($key, $middleware);
			array_push($middlewares['before'], $key);
		}
		
		array_push($this->router->groups, $middlewares);
	}
}