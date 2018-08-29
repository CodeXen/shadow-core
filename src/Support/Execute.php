<?php 

namespace Shadow\Support;

use Dwoo\Core as Dwoo;
use Shadow\Dumper\Dumper;

trait Execute {
	private $cryptKey = "qJB0rGtIn5UB1xG03efyCp";

	public function encrypt($q) {
		$cryptKey = $this->cryptKey;
		$qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
		return($qEncoded);
	}

	public function decrypt($q) {
		$cryptKey = $this->cryptKey;
		$qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
		return($qDecoded);
	}

	public function pre_dump($data) {
		echo '<pre>';
		print_r($data);
		echo '</pre>';

		exit;
	}

	public function dump($data, $hidden = true, $detailed = false) {
		return Dumper::dump($data, $hidden, $detailed);
		
		exit;
	}

	public function config($a = null, $b = null) {
		$config = parse_ini_file('../config.ini', true);
		
		$data = $config;
		if($a) {
			$data = $config[$a];
		}

		if($a && $b) {
			$data = $config[$a][$b];
		}
		
		return $data;
	}

	public function render($view, $data = array()) {
		$dwoo = new Dwoo();

		echo $dwoo->get('../application/Views/'. $view . '.dwoo.php', $data);

		exit;
	}

	public function view($view, $data = []) {
		return $this->app('View')->make($view, $data);
	}

	public function viewArc($view, $data = []) {
		return $this->app('View')->arc($view, $data);
	}

	public function validate($input, $rules = []) {
		return $this->app('Validate')->check($input, $rules);
	}
}