<?php

namespace Alisoftassets\Firststep;
use Illuminate\Support\ServiceProvider;

class FirstStepServiceProvider extends ServiceProvider {

	public function boot() {
		$this->loadRoutesFrom(__DIR__.'/routes/web.php');
	}

	public function register() {

	}
}