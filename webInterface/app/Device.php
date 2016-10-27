<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_id', 'activeFlag',
    ];

    public function user()
    {
        return $this->belongsToMany('User', 'device_user', 'device_id', 'user_id');
    }

}
