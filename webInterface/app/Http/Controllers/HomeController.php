<?php

namespace App\Http\Controllers;

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
    public function index()
    {

        // Perform database check
        $devicesTableAvailable = Schema::hasTable('devices');
        $usersTableAvailable = Schema::hasTable('users');
        $samplesTableAvailable = Schema::hasTable('samples');
        $deviceUserTableAvailable = Schema::hasTable('device_user');

        if ($devicesTableAvailable && $usersTableAvailable && $samplesTableAvailable && $deviceUserTableAvailable) {
            $databaseStatus = true;
        }

        return view('admin.controls', ['databaseTable' => $databaseStatus]);
    }
}
