@extends('common.basic')

@section('content')
<link href="./css/pairing.css" rel="stylesheet">

<button type="submit" class="btn btn-default" id="add-sample">
	<i class="fa fa-plus"></i> Add Sample
</button>



<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="./js/sample.js"></script>
@endsection