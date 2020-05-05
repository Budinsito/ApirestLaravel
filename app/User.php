<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const USUARIO_VERIFICADO = '1';
    const USUARIO_NO_VERIFICADO = '0';

    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';


protected $table = 'users';
protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    protected $hidden = [
        'password', 
        'remember_token',
        'verification_token',
    ];

    //Mutador que establece la primera letra del nombre es en minusculas
    public function setNameAttribute($valor){
        $this->attributes['name'] = strtolower($valor);
    }

//Solamente muestra en la salida mas no hace efectos en la base de datos 
    public function getNameAttribute($valor){
        //ucwords — Convierte a mayúsculas el primer caracter de cada palabra de una cadena
        return ucwords($valor);
    }


     public function setEmailAttribute($valor){
        $this->attributes['email'] = strtolower($valor);
    }


    public function esverificado(){
        return $this->verified == User::USUARIO_VERIFICADO;
    }

      public function esadministrador(){
        return $this->verified == User::USUARIO_ADMINISTRADOR;
    }

    public static function generarVerificationToken(){
        return Str::random(40);
    }
}
