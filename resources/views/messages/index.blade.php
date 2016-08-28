@extends('layouts.app')

@section('content')

<div class="container">

@include('layouts.errnmsgs')

    <!-- list messages --> {{-- INDEX --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Messages 
                <div class="pull-right">
                <a href="{{URL::to('messages/create')}}" ><i class="fa fa-plus-circle"  title="Add new user"></i> Add new message </a>&nbsp;
                {{--<a href="{{URL::to('recalculateAllResults')}}" > <i class="fa fa-plus-circle"  title="Add new user"></i>  Recalculate results <span> </span></a> --}}
                </div>
                </div>

                <div class="panel-body">
                   
                   <!-- table-striped table-bordered table-hover dt-responsive -->
                <table class="table display responsive msgstable" width="100%">
                    <thead>
                        <tr>
                            <th>title</th>
                            <th>author</th>
                            <th>created at</th>
                            <th>recipients</th>
                            <th>not seen by</th>
                            <th>not sent to</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($msgs as $msg)
                        <tr>
                            <td class="text-{{$msg->class}}">{{$msg->title}}</td>
                            <td>{{$msg->author->firstname}} {{$msg->author->lastname}}</td>
                            <td>{{$msg->created_at->format("d.m.Y H:i")}}</td>
                            <td><a href="#">{{$msg->recipients->count()}}</a></td>
                            <td><a href="#">13</a></td>
                            <td><a href="#">3</a></td>
                            <td class="tools"><a class="btn btn-xs btn-primary" href="{{URL::to('messages/'.$msg->id.'/edit')}}"><i aria-hidden="true" class="fa fa-pencil-square"></i></a>
                        </tr>
                    @endforeach
                       </tbody>
                   </table>

                </div>

            </div>
        </div>
    </div>

</div>
@endsection
