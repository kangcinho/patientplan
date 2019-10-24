<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','canInsert','canUpdate','canDelete','canAdmin', 'canEkspor'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'canInsert'=>'boolean',
        'canUpdate'=>'boolean',
        'canDelete'=>'boolean',
        'canAdmin'=>'boolean',
        'canEkspor'=>'boolean'
    ];

    protected $table = "users";
    public $incrementing = false;
    protected $primaryKey = 'idUser';

    public function getIDUser(){
        $tanggal = Date('ymd');
        $time = microtime(true) * 1000;
        $time = substr($time, -8,6);
        return  $tanggal.'USER-'.$time;
    }

    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function getAuthPassword(){
        return $this->password;
    }
}
