@extends('layouts.app')

@section('content')

<div class="container">

    @include('layouts.errnmsgs')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">User home</div>

                <div class="panel-body">
                    You are logged in!
                    but you are not affiliate...
                </div>
            </div>
        </div>
    </div>

</div> <!--container -->
@endsection
