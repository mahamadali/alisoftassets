<?php

namespace Alisoftassets\Firststep;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait Softasset {

	public $isObservable = false;

	public function __construct() {
	}

	public function setObservable(bool $isObservable = false) {
		$this->isObservable = $isObservable;
	}

	public function setColumnToObserve($model, $column = 'created_at') {
        if (!Schema::hasColumn($model->getTable(), $column)) {
        	Schema::table($model->getTable(), function (Blueprint $table) use ($column) {
        		if(strpos($column, '_at')) {
        			$table->datetime($column)->nullable();
        		} else if(strpos($column, '_by')) {
        			$table->bigInteger($column)->nullable();
        		}
            });
        }
    }

}