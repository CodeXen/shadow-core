<?php 

namespace Shadow\Request;

class Redirect 
{
	public function route() {

	}

	public static function back() {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	public static function url() {

	}

	public static function with($data = []) {

	}
}