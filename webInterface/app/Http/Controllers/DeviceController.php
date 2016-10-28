<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Http\Requests;
use App\Repositories\DeviceRepository;

class DeviceController extends Controller
{

    /**
     * The device repository instance.
     *
     * @var TaskRepository
     */
    protected $devices;

    protected $redirectTo = '/database';


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(DeviceRepository $devices)
    {
        $this->middleware('auth');
        $this->devices = $devices;
    }

    /**
     * Show the form for creating a new device.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

    }

    public function index(Request $request)
    {
        return view("database.test", [
            'devices' =>  $this->devices->getAll(),
            'devicelist' => $request->user()->devices,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showDevices(Request $request)
    {
        $userdevices = $request->user()->devices;
        return response()->json(view('database.devices', ['devicelist' => $userdevices])->render(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function pairDevice(Request $request)
    {
        $this->validate($request, [
            'deviceslist' => 'exists:devices,id',
        ]);

        $device_id = $request->deviceslist;
        $request->user()->devices()->attach($device_id);
        
        $userdevices = $request->user()->devices;
        return response()->json(view('database.devices', ['devicelist' => $userdevices])->render(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function unpairDevice(Request $request)
    {
        $this->validate($request, [
            'deviceslist' => 'exists:device_user,pivotdevice_id',
        ]);

        $device_id = $request->deviceslist;
        $request->user()->devices()->detach($device_id);

        $userdevices = $request->user()->devices;
        return response()->json(view('database.devices', ['devicelist' => $userdevices])->render(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
