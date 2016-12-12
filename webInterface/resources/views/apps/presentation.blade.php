@extends('common.basic')
@section('content')

<link href="{{ asset('css/presentation.css') }}" rel="stylesheet">

<body>
    <div class="arduino-status">
        <img src="{{ asset('img/arduino-3d.png') }}" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div><!-- /arduino-status -->
    <div class="container">
        <div class="panel-body">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="3"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="4"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="5"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="6"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="7"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="8"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="9"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="10"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="11"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="12"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="13"></li>
                </ol><!-- /carousel-indicators -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active"><img src="{{ asset('img/slides/Slide1.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide2.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide3.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide4.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide5.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide6.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide7.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide8.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide9.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide10.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide11.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide12.jpg') }}"></div>
                    <div class="item"><img src="{{ asset('img/slides/Slide13.jpg') }}"></div>
                </div><!-- /carousel-inner -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a><!-- /left carousel-control -->
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a><!-- /right carousel-control -->
            </div><!-- /carousel slide -->
            <button id="startPresentationBtn" class="btn btn-lg custom-btn btn-block">Start presentation</button>
        </div><!-- /panel-body -->
    </div><!-- /container -->
</body>

<script src="{{ asset('js/presentation.js') }}"></script>
@endsection
