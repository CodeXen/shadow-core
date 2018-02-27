<?php 

namespace Shadow\Validation;

use Shadow\Database\Pdox;
use Shadow\View\View;
use Shadow\Request\Redirect;


class Validate
{
	private $_passed = false,
			$_errors = [],
			$_db = null;

	public function __construct() {
		$this->_db = Pdox::instance();
	}

	public function check($source, $items = array()) {
		foreach($items as $item => $rules) {
			$clean_item = ucfirst(str_replace('_', ' ', $item));
			foreach($rules as $rule => $rule_value) {
				$value = trim($source[$item]);
				$clean_rule_value = ucfirst(str_replace('_', ' ', $rule_value));
				
				if($rule === 'required' && empty($value)) {
					$this->addError($item, "{$clean_item} is required");
				} else if(!empty($value)) {
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value) {
								$this->addError($item, "{$clean_item} must be a minimum of {$rule_value} charecters.");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value) {
								$this->addError($item, "{$clean_item} must be a maximum of {$rule_value} charecters.");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]) {
								$this->addError($item, "{$clean_rule_value} must match {$clean_item}.");								
							}
						break;
						case 'unique':
							$check = $this->_db->where($rule_value, [$item, '=', $value])->get();
							if($check->count()) {
								$this->addError($item, "{$clean_item} already exists.");
							}
						break;
					}
				}
			}
		}

		if(empty($this->_errors)) {
			$this->_passed = true;
		}
		
		return $this;
	}

	private function addError($key, $error) {
		$this->_errors[$key] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function has($key = null) {
		if(array_key_exists($key, $this->_errors)) {
			return true;
		}

		return false;
	}

	public function first($key = null) {
		// if(array_key_exists($key, $this->_errors)) {
			return $this->_errors;
		// }

		return "";
	}

	public function passed() {
		return $this->_passed;
	}
}