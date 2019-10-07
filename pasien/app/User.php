<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username','canInsert','canUpdate','canDelete','canAdmin'
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
}
