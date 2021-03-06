<?php

namespace Alisoftassets\Firststep;
use Illuminate\Support\ServiceProvider;
use App\Models\Invoice;
use Alisoftassets\Firststep\SoftAssetObserver\SoftAssetObserver;

class FirstStepServiceProvider extends ServiceProvider {

	public function boot() {
		require_once('Observer.php');
		Invoice::observe(new SoftAssetObserver());
	}

	public function register() {
	}
}