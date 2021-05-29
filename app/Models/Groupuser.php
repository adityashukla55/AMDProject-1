<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupuser extends Model
{
    use HasFactory;

    protected $table = 'group_user';

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'group_id', 'user_id','gro', 'joined'
    ];

    public function group(){
        return $this->belongsTo(Group::class, 'group_id',);
    }
    
    public function meeting(){
        return $this->belongsTo(Meeting::class, 'group_id',);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
