@extends('layouts.app')

@section('content')

<div class="container">

    @include('layouts.errnmsgs')

    @if($editOrCreateCategory)
        @include('categories.create')
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Incentive items category list
                <a class="pull-right" href="{{URL::to('categories/create')}}" ><i class="fa fa-plus-circle"  title="Add new category"></i> Add new category</a></div>

                <div class="panel-body">
                   
                <table class="table itemstable table-striped table-bordered table-hover dt-responsive" width="100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td class="tools">
                                <a class="btn btn-xs btn-primary" href="{{URL::to('categories/'.$category->id.'/edit')}}"><i aria-hidden="true" class="fa fa-pencil-square"></i></a>

                                <a class="btn btn-xs btn-danger deleteItem"  title="Delete item?" data-token="{{ csrf_token() }}" data-myhref="{{URL::to('categories/'.$category->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a>

                        </tr>
                    @endforeach
                       </tbody>
                   </table>

                </div>

            </div>
        </div>
    </div>

</div> <!--container -->
@endsection
