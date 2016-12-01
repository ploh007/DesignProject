<?php

namespace App\Http\Controllers;

use App\DeviceUser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application admin page and logout controls.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // Perform database check
        $devicesTableAvailable = Schema::hasTable('devices');
        $usersTableAvailable = Schema::hasTable('users');
        $samplesTableAvailable = Schema::hasTable('samples');
        $deviceUserTableAvailable = Schema::hasTable('device_user');

        if ($devicesTableAvailable && $usersTableAvailable && $samplesTableAvailable && $deviceUserTableAvailable) {
            $databaseStatus = true;
        }

        // Perform user metrics check

        $userDevicesCount = $request->user()->devices()->count();
        $userID = $request->user()->id;
        $sampleCount = DeviceUser::where('pivotuser_id','=',$userID)->first()->samples->count();

        return view('admin.controls', ['databaseTable' => $databaseStatus, 'userDevices' => $userDevicesCount, 'userID' => $userID, 'sampleCount' => $sampleCount]);
    }
}
