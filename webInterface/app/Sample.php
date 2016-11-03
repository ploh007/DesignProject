<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sample_id', 'gestureName', 'sampleData', 'pair_id'
    ];

    public function device()
    {
        return $this->belongsTo('App\DeviceUser', 'pair_id');
    }
}
