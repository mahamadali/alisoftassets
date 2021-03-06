<?php 

namespace Alisoftassets\Firststep\SoftAssetObserver;
use Alisoftassets\Firststep\Softasset;
use Illuminate\Database\Eloquent\Model;
use Auth;

class SoftAssetObserver {

    use Softasset;

    protected $accessor_id;

    public function __construct() {
        $this->accessor_id = Auth::user()?Auth::user()->id:null;
    }

    public function updating($model)
    {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->modified_by = $this->accessor_id;
        $model->modified_at = date('Y-m-d H:i:s');
    }

    public function updated($model) {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->modified_by = $this->accessor_id;
        $model->modified_at = date('Y-m-d H:i:s');
    }

    public function creating($model)
    {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->created_by = $this->accessor_id;
        $model->created_at = date('Y-m-d H:i:s');
    }

    public function created($model)
    {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->created_by = $this->accessor_id;
        $model->created_at = date('Y-m-d H:i:s');
    }

    public function removing($model)
    {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->purged_by = $this->accessor_id;
        $model->modified_at = date('Y-m-d H:i:s');
        $model->deleted_at = date('Y-m-d H:i:s');
    }

    public function saved($model)
    {
        if(!$model->isObservable) {
            return;
        }
        $this->setColumnsToObserver($model);
        $model->created_by = $this->accessor_id;
    }

    public function setColumnsToObserver($model) {
        $this->setColumnToObserve($model, 'created_by');
        $this->setColumnToObserve($model, 'created_at');
        $this->setColumnToObserve($model, 'modified_by');
        $this->setColumnToObserve($model, 'modified_at');
        $this->setColumnToObserve($model, 'purged_by');
        $this->setColumnToObserve($model, 'deleted_at');
    }

}