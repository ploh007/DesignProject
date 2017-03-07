@extends('common.basic')
@section('content')

<body>
    <div class="jumbotron red-jumbotron" data-wow-duration="2s">
        <div class="container">
            <h2>Login to use the Gesture Control Device</h2>
            <p>Signing up with the gesture control device enables you to calibrate, manage and use apps with the device.</p>
        </div><!-- /container -->
    </div><!-- /jumbotron red-jumbotron -->
    <div class="container">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Login
                        </div><!-- /panel-heading -->
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                                {{ csrf_field() }}
                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus> 
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span> 
                                        @endif
                                    </div><!-- /col-md-6 -->
                                </div><!-- /form-group -->
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Password</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required> 
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div><!-- /col-md-6 -->
                                </div><!-- /form-group -->
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="remember"> Remember Me</label>
                                        </div><!-- /checkbox -->
                                    </div><!-- /col-md-6 col-md-offset-4 -->
                                </div><!-- /form-group -->
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-4">
                                        <button type="submit" class="btn btn-default">Login</button>
                                        <a class="btn btn-default" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                                    </div><!-- /col-md-8 col-md-offset-4 -->
                                </div><!-- /form-group -->
                            </form><!-- /form-horizontal -->
                        </div><!-- /panel-body -->
                    </div><!-- /panel panel-default -->
                </div><!-- /col-md-8 col-md-offset-2 -->
            </div><!-- /row -->
        </div><!-- /panel-body -->
    </div><!-- /container -->
</body>
@endsection
