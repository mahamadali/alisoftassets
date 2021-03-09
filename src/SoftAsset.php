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

	public function attachOn($event = 'create', $callback) {
		if(empty($this->attachedEvents[$event])) {
			$this->attachedEvents[$event] = [];	
		}
        $this->attachedEvents[$event][] = $callback;
    }

    public function dispatchEvents($event = 'create', $model) {
    	if(empty($model->attachedEvents[$event])) {
    		return;
    	}
        foreach ($model->attachedEvents[$event] as $callback) {
            if(is_callable($callback)) {
                call_user_func($callback);
            }
        }
    }

	public function setColumnToObserve($model, $columnType = 'created_at', $columnAction = 'CREATION_TIME') {
		if(count($this->standardColumnsPerAction[$columnAction]) == 0) {
			return;
		}

		$columnToSet = NULL;
		foreach ($this->standardColumnsPerAction[$columnAction] as $columnToCheck) {
			if (Schema::hasColumn($model->getTable(), $columnToCheck)) {
				$columnToSet = $columnToCheck;
				break;
			}
		}

		if($columnToSet != NULL) {
			$this->columns[$columnType] = $columnToSet;
		} 

		$column = $this->columns[$columnType];

        if (!Schema::hasColumn($model->getTable(), $column)) {
        	Schema::table($model->getTable(), function (Blueprint $table) use ($column) {
        		if(strpos($column, '_at')) {
        			$table->datetime($column)->nullable();
        		} else if(strpos($column, '_by')) {
        			$table->bigInteger($column)->nullable();
        		}
            });
        }
        $this->columns[$column] = $column;

    }

}