<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \DateTimeInterface;

class Meeting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'name', 'group_id','location','start_time','end_time','hidden'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $dates = [
        'end_time',
        'start_time',
        'created_at',
        'updated_at',
    ];

    // protected $value = [
    //     'end_time',
    //     'start_time'
    // ];

    // public function getDateStartAttribute($value)
    // {
    //     return Carbon::parse($value)->format('Y-m-d\TH:i');
    // }
    
    // public function getDateStartAttribute($value)
    // {
    //     return Carbon::parse($value)->format('Y-m-d\TH:i');
    // }

    // protected $casts = [
    //     'end_time ' => 'datetime-local:Y-m-d',
    //     'start_time'=> 'datetime:Y-m-d H:i:s',
    // ];
    


    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function group()
    {
        // return $this->hasOne(Group::class,'group_id','user_id');
        return $this->belongsTo(Group::class, 'group_id','id');
    }
    public function groupuser()
    {
        return $this->belongsTo(Groupuser::class,'user_id', 'group_id');
    }
   
}
