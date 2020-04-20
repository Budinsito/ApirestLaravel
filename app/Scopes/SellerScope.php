<?php
namespace App\Scopes;
use App\Transaccions;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class SellerScope implements Scope {

	public function apply(Builder $builder, Model $model){
		$builder->has('products');

	}

}