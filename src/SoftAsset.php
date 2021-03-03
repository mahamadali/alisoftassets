<?php

namespace Alisoftassets\Firststep;
use Illuminate\Database\Eloquent\Model;

trait Softasset {
	public function fields() {
		return array_merge(\Schema::getColumnListing($this->getTable()), $this->attributesToArray());
	}
}