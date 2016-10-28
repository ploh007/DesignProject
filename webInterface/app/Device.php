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
        return $this->belongsToMany('App\User', 'device_user', 'pivotdevice_id', 'pivotuser_id');
    }

    public function samples()
    {
        return $this->hasMany('App\Sample');
    }

}
