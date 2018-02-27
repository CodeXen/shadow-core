<?php 

namespace Shadow\Core;

use Shadow\Support\ServiceProviderInterface;
use Shadow\Router\Router;

use Whoops\Run as WhoopsRun;
use Whoops\Handler\PrettyPageHandler as WhoopsPrettyPageHandler;

class Application extends Container
{
	protected $loadedProviders = [];
	protected $providersList = [];
	
	public function __construct() {
		$this->providersList = config('app', 'providers');
	}

	public function run() {
		$this->initWhoops();
		$this->setupRouter();
	}

	public function connectDatabase() {
	}

	public function app($key = null) {	
		
		$this->bind($key, $this->providersList[$key]);
		$resolve = $this->resolve($key);

		return $resolve;
	}

	public function initWhoops() {
		$whoops = new WhoopsRun();
		$handler = new WhoopsPrettyPageHandler();

		$whoops->pushHandler($handler)->register();

		return $this;
	}

	public function initBind() {
		$this->bind('Router', 'Shadow\Router\Router');
		$this->bind('Input', 'Shadow\Request\Input');
		$this->bind('View', 'Shadow\View\View');
		$this->singleton('Database', 'Shadow\Database\Database');
		
		$this->resolve('Input');
	}

	public function setupRouter() {
		$router = new Router();
		
		require_once "../application/Routes/web.php";
	}

	public function registerProvider(ServiceProviderInterface $provider) {
		if(!$this->providerHasBeenLoaded($provider)) {
			$provider->register($this);
			
			$this->loadedProviders[] = get_class($provider);
		}

		return $this;
	}

	protected function providerHasBeenLoaded(ServiceProviderInterface $provider) {
		return array_key_exists(get_class($provider), $this->loadedProviders);
	}
}