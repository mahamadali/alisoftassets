<?php

namespace Alisoftassets\Firststep;
use Illuminate\Support\ServiceProvider;
use App\Models\Invoice;
use Alisoftassets\Firststep\SoftAssetObserver\SoftAssetObserver;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class FirstStepServiceProvider extends ServiceProvider {

	public function boot() {
		require_once('Observer.php');
		$models = $this->getModels();
		foreach($models as $model) {
			$model::observe(new SoftAssetObserver());	
		}
	}

	public function register() {
	}

	public function getModels(): Collection {
	    $models = collect(File::allFiles(app_path()))
	        ->map(function ($item) {
	            $path = $item->getRelativePathName();
	            $class = sprintf('\%s%s',
	                Container::getInstance()->getNamespace(),
	                strtr(substr($path, 0, strrpos($path, '.')), '/', '\\'));

	            return $class;
	        })
	        ->filter(function ($class) {
	            $valid = false;

	            if (class_exists($class)) {
	                $reflection = new \ReflectionClass($class);
	                $valid = $reflection->isSubclassOf(Model::class) &&
	                    !$reflection->isAbstract();
	            }

	            return $valid;
	        });

	    return $models->values();
	}

}