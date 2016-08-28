@extends('layouts.app')

@section('content')

<div class="container">

    @include('layouts.errnmsgs')


    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Active incentive items list</div>

                <div class="panel-body">
                   
                <table class="table table-striped table-bordered table-hover dt-responsive overviewtable" width="100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>sku</th>
                            <th>pn</th>
                            <th>category</th>
                            <th>brand</th>
                            <th>pts</th>
{{--
                            <th title="Qty of items sold">score qty</th>
                            <th title="Total pts scored">score pts</th>
--}}
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr> 
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->sku}}</td>
                            <td>{{$item->pn}}</td>
                            <td>{!!($item->category) ? $item->category->name : '<span class="text-danger">Undefined</span>'!!}</td>
                            <td>{!!($item->brand) ? $item->brand->name : '<span class="text-danger">Undefined</span>'!!}</td>
                            <td>{!!($item->latestpoints) ? $item->latestpoints->points : "0" !!}</td>
{{--
                            <td>{{$item->realisations->count()}}  </td>
                            <td>{{$item->realisations->sum('pivot.points')}}  </td>
--}}
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
