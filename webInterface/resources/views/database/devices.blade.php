@if (count($devicelist) > 0)
	@foreach ($devicelist as $userdevice)
	<tr>
	    <td>{{$userdevice->id}}</td>
	    <td>{{$userdevice->activeFlag}}</td>
	</tr>
	@endforeach
	@else
	<tr>
	    <td>No Devices</td>
	    <td>-</td>
	</tr>
@endif