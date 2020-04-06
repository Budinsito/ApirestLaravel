<?php

namespace App;

use App\Transaccion;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{

    public function transaccions(){
    	return $this->hasMany(Transaccion::class);
    }

}
