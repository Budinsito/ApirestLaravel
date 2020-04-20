<?php

namespace App;

use App\Transaccion;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\BuyerScope;

class Buyer extends User
{


	protected static function boot(){
		parent::boot();
		static::addGlobalScope(new BuyerScope);
	}

    public function transaccions(){
    	return $this->hasMany(Transaccion::class);
    }

}
