<?php 

if(! function_exists('config')) {
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
}

if(! function_exists('remote')) {
	function remote($a = null, $b = null) {
		if(strpos(getcwd(), 'public') !== false) {
			$filepath = getcwd() . '/../remote.ini';
		} else {
			$filepath = getcwd() . '/remote.ini';
		}
		$config = parse_ini_file($filepath, true);
		
		$data = $config;
		if($a) {
			$data = $config[$a];
		}

		if($a && $b) {
			$data = $config[$a][$b];
		}
		
		return $data;
	}
}

if(! function_exists('predump')) {
	function predump($data = null) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
	}
}


if(! function_exists('dump')) {
	function dump($data = null) {
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		exit;
	}
}

if(! function_exists('url')) {
	function url($url) {
		return baseUrl() . $url;
	}
}

if(! function_exists('redirect')) {
	function redirect($path) {
		$path = trim($path , '/');
		header('Location: '. baseUrl() . $path);
		die();
	}
}

if(! function_exists('render')) {
	function render($view, $data = array()) {
		$template = new Shadow\View\Raze;
		
		$template->render($view, $data);
	}
}

if(! function_exists('viewPath')) {
	function viewPath($view) {
		return '../application/Views/'.$view.'.dwoo.php';
	}
}

if(! function_exists('input')) {
	function input() {
		return new Shadow\Request\Input();
	}
}

if(! function_exists('validator')) {
	function validator() {
		return new Shadow\Validation\Validate();
	}
}

if(! function_exists('baseUrl')) {
	function baseUrl() {
		// output: /myproject/index.php
		$currentPath = $_SERVER['PHP_SELF']; 

		// output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index ) 
		$pathInfo = pathinfo($currentPath); 

		// output: localhost
		$hostName = $_SERVER['HTTP_HOST']; 

		// output: http://
		$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://'?'https://':'http://';
		
		return $protocol.$hostName;
	}
}

if(! function_exists('debugbar')) {
	// vendor_path();
	function debugbar() {
		$baseurl = baseUrl();
		$debugbar = new DebugBar\StandardDebugBar();
		$debugbarRenderer = $debugbar->getJavascriptRenderer('../vendor/maximebf/debugbar/src/DebugBar/Resources/');

		$debugbar["messages"]->addMessage("Shadow Framework for kapitans!");

		return $debugbarRenderer;	
	}
}

if(! function_exists('view')) {
	function view($view, $data = []) {
		return Shadow\View\View::render($view, $data);
	}
}

if(! function_exists('_csrfToken')) {
	function _csrfToken() {
		return $_SESSION['_csrfToken'];
	}
}

if(! function_exists('encrypt')) {
	function encrypt($q) {
		$cryptKey = "qJB0rGtIn5UB1xG03efyCp";
		$qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
		return $qEncoded;
	}
}

if(! function_exists('decrypt')) {
	function decrypt($q) {
		$cryptKey = "qJB0rGtIn5UB1xG03efyCp";
		$qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
		return $qDecoded;
	}
}