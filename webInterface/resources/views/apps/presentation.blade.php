@extends('common.basic') @section('content')
<link href="./css/presentation.css" rel="stylesheet">
<!-- BODY COMPONENT -->

<body>
    <div class="arduino-status">
        <img src="./img/arduino-3d.png" width="100px">
        <h6 id="arduino-status-text"> Not Connected </h6>
        <h6 id="arduino-status-mode"> Mode: Idle </h6>
    </div>
    <div class="container">

        <div class="panel-body">
        <!-- BOOTSTRAP CAROUSEL -->
        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" data-interval="false">
            <!-- Indicators -->
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
            </ol>
            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <div class="item active">
                    <img src="./img/slides/Slide1.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide2.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide3.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide4.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide5.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide6.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide7.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide8.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide9.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide10.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
                <div class="item">
                    <img src="./img/slides/Slide11.jpg">
                    <div class="carousel-caption">
                    </div>
                </div>
            </div>
            <!-- Controls -->
            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <button id="startPresentationBtn" class="btn btn-lg custom-btn btn-block">Start presentation</button>
        </div>
    </div>
    <script src="./js/presentation.js"></script>
</body>
@endsection
