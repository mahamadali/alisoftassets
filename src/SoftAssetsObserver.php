<?php 

namespace Alisoftassets\Firststep;

use Alisoftassets\Firststep\Softasset;
use Illuminate\Database\Eloquent\Model;
use Auth;

class SoftAssetsObserver {

    use Softasset;

    protected $accessor_id;
    protected $standardColumnsPerAction;
    protected $columns = [];

    public function __construct() {
        $this->accessor_id = Auth::user()?Auth::user()->id:rand(101,200);
        $this->standardColumnsPerAction = [
            'CREATION_TIME' => [
                'created_at',
                'added_at',
                'inserted_at',
                'created_on',
                'added_on',
            ],
            'UPDATION_TIME' => [
                'updated_at',
                'modified_at',
                'changed_at',
                'updated_on',
                'modified_on',
                'changed_on',
            ],
            'CREATION_BY' => [
                'created_by',
                'added_by',
                'inserted_by',
            ],
            'UPDATION_BY' => [
                'updated_by',
                'modified_by',
                'changed_by',
            ],
            'DELETING_TIME' => [
                'deleted_at',
                'deleted_on',
                'purged_at',
                'purged_on',
                'destroyed_at',
                'destroyed_on',
                'removed_at',
                'removed_on',
            ],
            'DELETED_BY' => [
                'deleted_by',
                'purged_by',
                'destroyed_by',
                'removed_by',
            ],
        ];
        $this->columns['CREATED_AT'] = 'created_at';
        $this->columns['CREATED_BY'] = 'created_by';
        $this->columns['UPDATED_AT'] = 'updated_at';
        $this->columns['UPDATED_BY'] = 'updated_by';
        $this->columns['DELETED_AT'] = 'deleted_at';
        $this->columns['DELETED_BY'] = 'deleted_by';
    }

    public function updating($model) {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->{$this->columns['UPDATED_BY']} = $this->accessor_id;
        $model->{$this->columns['UPDATED_AT']} = date('Y-m-d H:i:s');
        $this->dispatchEvents('updating', $model);
    }

    public function updated($model) {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->{$this->columns['UPDATED_BY']} = $this->accessor_id;
        $model->{$this->columns['UPDATED_AT']} = date('Y-m-d H:i:s');
        $this->dispatchEvents('updated', $model);
    }

    public function creating($model) {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->{$this->columns['CREATED_BY']} = $this->accessor_id;
        $model->{$this->columns['CREATED_AT']} = date('Y-m-d H:i:s');
        $model->{$this->columns['UPDATED_AT']} = date('Y-m-d H:i:s');
        $model->{$this->columns['UPDATED_AT']} = date('Y-m-d H:i:s');
        $this->dispatchEvents('creating', $model);
    }

    public function created($model) {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->{$this->columns['CREATED_BY']} = $this->accessor_id;
        $model->{$this->columns['CREATED_AT']} = date('Y-m-d H:i:s');
        $this->dispatchEvents('created', $model);
    }

    public function removing($model) {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->{$this->columns['DELETED_BY']} = $this->accessor_id;
        $model->{$this->columns['UPDATED_AT']} = date('Y-m-d H:i:s');
        $model->{$this->columns['DELETED_AT']} = date('Y-m-d H:i:s');
        $this->dispatchEvents('removing', $model);
    }

    public function saved($model) {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->{$this->columns['CREATED_BY']} = $this->accessor_id;
        $model->{$this->columns['UPDATED_BY']} = $this->accessor_id;
        $model->{$this->columns['UPDATED_AT']} = date('Y-m-d H:i:s');
        $this->dispatchEvents('save', $model);
    }

    public function setColumnsToObserver($model) {
        $this->setColumnToObserve($model, 'CREATED_BY', 'CREATION_BY');
        $this->setColumnToObserve($model, 'CREATED_AT', 'CREATION_TIME');
        $this->setColumnToObserve($model, 'UPDATED_BY', 'UPDATION_BY');
        $this->setColumnToObserve($model, 'UPDATED_AT', 'UPDATION_TIME');
        $this->setColumnToObserve($model, 'DELETED_BY', 'DELETED_BY');
        $this->setColumnToObserve($model, 'DELETED_AT', 'DELETING_TIME');
    }
}