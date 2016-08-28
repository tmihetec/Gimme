<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gimme!</title>

    <link rel="stylesheet" type='text/css' href="{{asset("css/fonts.css")}}">
    <link rel="stylesheet" href="{{asset("libs/font-awesome-4.6.3/css/font-awesome.min.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("libs/bootstrap-3.3.6/css/bootstrap.min.css")}}"/>


    <style>
        html { 
            background-color: #999;
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
        <div class="col-md-8 col-md-offset-2">
        <div class="logo">H18.Gimme!</div>
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-envelope"></i>Send Password Reset Link
                                </button>
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
