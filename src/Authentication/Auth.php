<?php 

namespace Shadow\Authentication;

use Shadow\Database\Pdox;

class Auth 
{
	public function login($params = array(), $return) {
		$user = Pdox::instance()->table('users')->where('username', $params['username'])->get();
		
		if(count($user)) {
			if ($user->password == $params['password']) {
				$_SESSION['shadow']['auth'] = $user->id;
				
				return $return();
			}	
		} else {
			echo json_encode("user_not_found");
		}
	}

	public function user() {
		if(self::checkSession()) {
			$user = Database::con()->findOne('users', ['id', '=', $_SESSION['shadow']['auth']]);
			return $user;
		}
		
		// return false;
	}

	public static function checkSession() {
		if (isset($_SESSION['shadow']['auth']) && $_SESSION['shadow']['auth']) {
			return true;
		}

		return false;
	}
	
	public static function check() {
		return self::checkSession();
	}

	public static function logout() {
		unset($_SESSION['shadow']['auth']);
	}

}