<?php 

namespace Shadow\Console;

use App\Console\GreetCommand;
use Symfony\Component\Console\Application;

class Kapitan
{
	public $application;

	public function application() {
		$this->application = new Application();
	}

	public function register($command) {
		$this->application->add($command);
	}

	public function run() {
		$this->application->run();
	}

}



