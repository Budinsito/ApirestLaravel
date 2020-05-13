<?php

namespace App;
use App\Category;
use App\Seller;
use App\Transaccion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

use SoftDeletes;
    
	const PRODUCTO_DISPONIBLE='disponible';
	const PRODUCTO_NO_DISPONIBLE='no disponible';
    
    protected $dates = ['deleted_at'];
    protected $fillable = [
    	'name',
    	'description',
    	'quantity',
    	'status',
    	'image',
    	'seller_id'
    ];


// Oculta los campos pivot
    protected $hidden = [
        'pivot'
    ];

    public function estadodisponible(){

    	return $this->status==Product::PRODUCTO_DISPONIBLE;
    }


public function seller(){
    return $this->belongsTo(Seller::class);
}

public function transaccions(){
    return $this->hasMany(Transaccion::class);
}

    public function categories(){

        return $this->belongsToMany(Category::class);
    }
}
