<?php 

function config($file = null, $key = null) {
	if($file) {	
		$array = include "../bin/config/" . $file . ".php";
		$config = $array;
		
		if($key) {
			$config = $array[$key];
		}
		
		return $config;
	}

	return null;
}

function remote($a = null, $b = null) {
	$config = parse_ini_file('../remote.ini', true);
	
	$data = $config;
	if($a) {
		$data = $config[$a];
	}

	if($a && $b) {
		$data = $config[$a][$b];
	}
	
	return $data;
}

function predump($data = null) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

function dumpexit($data = null) {
	echo "<pre>";
	print_r($data);
	echo "</pre>";
	exit;
}

function url($url) {
	// $baseurl = remote('application', 'APP_URL');

	return baseUrl() . $url;
}

function redirect($path) {
	$baseurl = remote('application', 'APP_URL');

	header('Location: '. baseUrl() . $path);
	die();
}

function render($view, $data = array()) {
	$core = new Dwoo\Core();
	$debugbar = debugbar();
	$core->setCompileDir('../bin/storage/views/compiled/');
	echo $core->get('../application/Views/'. $view . '.dwoo.php', $data);
	echo $debugbar->renderHead();
	echo $debugbar->render();	

	exit;
}

function input() {
	return new Shadow\Request\Input();
}

function validator() {
	return new Shadow\Validation\Validate();
}

function baseUrl() {
	// output: /myproject/index.php
	$currentPath = $_SERVER['PHP_SELF']; 

	// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
	$pathInfo = pathinfo($currentPath); 

	// output: localhost
	$hostName = $_SERVER['HTTP_HOST']; 

	// output: http://
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';

	// return: http://localhost/myproject/
	return $protocol.$hostName.$pathInfo['dirname']."/";
}

function debugbar() {
	$baseurl = baseUrl();
	$debugbar = new DebugBar\StandardDebugBar();
	$debugbarRenderer = $debugbar->getJavascriptRenderer("http://localhost/mindspace/shadow/vendor/maximebf/debugbar/src/DebugBar/Resources/");

	$debugbar["messages"]->addMessage("Shadow Framework for kapitans!");

	return $debugbarRenderer;	
}

function view($view, $data = []) {
	return Shadow\View\View::make($view, $data);
}