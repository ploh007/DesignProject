<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceUser extends Model
{

    protected $table = 'device_user';
    protected $primaryKey = 'pair_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pair_id', 'pivotuser_id', 'pivotdevice_id',
    ];

    public function samples()
    {
        return $this->hasMany('App\Sample', 'pair_id');
    }
}
