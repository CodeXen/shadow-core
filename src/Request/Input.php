<?php 

namespace Shadow\Request;

class Input 
{
	public static function exists($type = 'post') {
		switch($type) {
			case 'post':
				return (!empty($_POST)) ? true : false;
			break;

			case 'get';
				return (!empty($_GET)) ? true : false;
			break;

			default:
				return false;
			break;
		}
	}

	public static function get($item) {
		if(isset($_POST[$item])) {
			return $_POST[$item];
		} else if (isset($_GET[$item])) {
			return $_GET[$item];
		}

		return '';
	}

	public static function all() {
		$input = [];
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$input = $_POST;
		} else {
			$input = $_GET;
			if(isset($input['url'])) {
				unset($input['url']);
			}
		}
		
		unset($input['_csrfToken']);
		
		return $input;
	}

	
}