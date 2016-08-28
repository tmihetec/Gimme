<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gimme!</title>

{{--
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}


    <link rel="stylesheet" type='text/css' href="{{asset("css/fonts.css")}}">
    <link rel="stylesheet" href="{{asset("libs/font-awesome-4.6.3/css/font-awesome.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("libs/bootstrap-3.3.6/css/bootstrap.min.css")}}"/>


    <style>
        html { 
          background: url("/images/bg.jpg") no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;          
        }
        body {
            
            font-family: 'Jaldi', sans-serif;
            background-color: transparent !important;
        }

        .logo{margin-top:90px;
                    font-family: 'Jaldi';
                    font-size: 50px;
                    font-weight: bold;
                    text-align: left;
                    color:#fff;
                    text-shadow: 1px 1px rgb(0,0,0);
                    text-shadow: 1px 1px rgba(0,0,0,.8);
            }
        .panel{
            margin-top:0px;
            background-color: rgb(255,255,255) !important;
            background-color: rgba(255,255,255,.8) !important;
        }
        .panel-body{
            padding:40px 0px 20px 0px;
        }
        .panel-heading{

        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="landing-layout">

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
        <div class="logo">H18.Gimme!</div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-7">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-7">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i>Login
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- 
    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
 --}}
 
    <script type="text/javascript" src="{{asset("libs/jquery/jquery-2.2.4.min.js")}}"></script>    
    <script type="text/javascript" src="{{asset("libs/bootstrap-3.3.6/js/bootstrap.min.js")}}"></script>


    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

</body>
</html>
