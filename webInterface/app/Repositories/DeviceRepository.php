<?php

namespace App\Repositories;

use App\Device;

class DeviceRepository
{

    /**
     * Get all of the devices.
     *
     * @return Collection
     */
    public function getAll()
    {
        return Device::all();
    }

    /**
     * Get all of the devices which are not-active.
     *
     * @return Collection
     */
    public function getAvailable()
    {
        return Device::where('activeFlag', false)
                    ->orderBy('created_at', 'asc')
                    ->get();
    }

}