<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Sample;
use App\DeviceUser;
use App\Http\Requests;
use App\Repositories\DeviceRepository;

use GestureRecognition\GestureSample;
use GestureRecognition\Comparator;

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
            'deviceslist' => 'exists:devices,id'
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
     * Retrieves the samples associated with the current connected device
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getSamples(Request $request)
    {
        // Data from User Mode
        $gestureSamplesArray = array();
        $userID = $request->user()->id;
        $rawSamples = DeviceUser::where('pivotuser_id', '=', $userID)->first()->samples;

        // Get Samples and create FFT
        foreach ($rawSamples as $rawSample) {
            // Create a gestureSample

            $rawString = $rawSample->sampleData;

            $dataString = explode(";", $rawString);

            // Seperate on commas
            $dataArrayX = array_map('intval', explode(",", $dataString[0]));
            $dataArrayY = array_map('intval', explode(",", $dataString[1]));
            $dataArrayZ = array_map('intval', explode(",", $dataString[2]));

            $gestureSample = new GestureSample($dataArrayX, $dataArrayY, $dataArrayZ, $rawSample->gestureName);

            array_push($gestureSamplesArray, $gestureSample);
        }

        // Create Instance of Comparator
        $comparator = new Comparator($gestureSamplesArray);

        $sampleSampleData = $request->sampleData;

        $dataSampleString = explode(";", $sampleSampleData);
        $sampleDataArrayX = array_map('intval', explode(",", $dataSampleString[0]));
        $sampleDataArrayY = array_map('intval', explode(",", $dataSampleString[1]));
        $sampleDataArrayZ = array_map('intval', explode(",", $dataSampleString[2]));

        $recognizedGesture = $comparator->getGesture($sampleDataArrayX, $sampleDataArrayY, $sampleDataArrayZ);

        return response()->json([
                                'data' => $recognizedGesture,
                            ], 200);

        // return $gestureSamplesArray;
    }

    // Creates a sample
    public function createSample(Request $request)
    {
        // Request should contain the sampledata, pairid, gesturename
        // $this->validate($request, [
        //     'pair_id' => 'exists:device_user,pair_id',
        //     'gestureName' => 'required|max:255',
        //     'sampleData' => 'required',
        // ]);

        $sample = new Sample;
        $sample->gestureName = $request->gestureName;
        $sample->sampleData = $request->sampleData;

        $userID = $request->user()->id;
        $pair_id = DeviceUser::where('pivotuser_id', '=', $userID)->first()->pair_id;

        $sample->pair_id = $pair_id;


        $sample->save();

        return response()->json([
                                'data' => ' Some data response ',
                            ], 200);
    }

    public function addCalibrationSample(Request $request)
    {
        // Request should contain the sampledata, pairid, gesturename
        $this->validate($request, [
            'pair_id' => 'exists:device_user,pair_id',
            'gestureName' => 'required|max:255',
            'sampleData' => 'required',
        ]);

        $sample = new Sample;
        $sample->gestureName = $request->gestureName;
        $sample->sampleData = $request->sampleData;
        $sample->pair_id = $request->pair_id;
        $sample->save();

        return response()->json([
                                'data' => ' Some data response ',
                            ], 200);
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
