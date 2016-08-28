@extends('layouts.app')

@section('content')

<div class="container">

    @include('layouts.errnmsgs')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-black">
                <div class="panel-heading"><i class="fa fa-bar-chart" aria-hidden="true"></i> {{$panelTitle}} {{$affiliate->display_name}} [<a href="{{URL::to('users')}}">back to user table</a>]</div>
                <div class="panel-body">
                    <div class="row">
                    <div class="col-sm-12">

                    @include('realisation.table')

                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
@endsection
