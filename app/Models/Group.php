<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'topic', 'user_id','description','count_limit','filled',
    ];

    // public function groups(){
    //     return $this->hasMany(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function meeting()
    // {
    //     return $this->belongsTo(Meeting::class, 'group_id', 'id');
    // }

    public function group()
    {
        return $this->hasOne(Meeting::class, 'group_id', 'id');
    }
    
    public function groupuser()
    {
        return $this->belongsTo(Groupuser::class,'user_id', 'group_id');
    }
}
