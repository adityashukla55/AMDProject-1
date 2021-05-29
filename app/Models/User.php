<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'group_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    // public function groups(){
    //     return $this->hasMany(Group::class);
    // }
    public function group()
    {
        return $this->hasOne(Group::class, 'user_id');
    }

    public function groupuser()
    {
        return $this->hasMany(Groupuser::class, 'user_id', 'group_id');
    }

    // public function user() {
    //     return $this->belongsTo(Group::class);
    // }

}
