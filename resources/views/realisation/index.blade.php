@extends('layouts.app')

@section('content')

<div class="container">

    @include('layouts.errnmsgs')

    @include('realisation.boxes')


    <div class="row ">
        <div class="col-md-6">
            <div class="panel panel-default panel-black" >
                <div class="panel-heading"><i class="fa fa-bar-chart" aria-hidden="true"></i> Top 10 Items sold</span></div>
                <div class="panel-body">
                    <div class="row" >
                        <div class="col-sm-12">
                           <table class="table table-striped">
                               <thead>
                                  <tr>
                                     <th>#</th>
                                     <th>Item</th>
                                     <th>qty</th>
                                     <th>points</th>
                                 </tr>
                             </thead>
                             <tbody>
                              @foreach($topfive as $item)
                              <tr>
                                 <td>{{$counter++}}</td>
                                 <td>{{$item->name}}</td>
                                 <td>{{$item->qty}}</td>
                                 <td>{{$item->total}}</td>
                             </tr>
                             @endforeach
                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <div class="col-md-6 ">
    <div class="panel panel-default panel-black">
        <div class="panel-heading"><i class="fa fa-line-chart" aria-hidden="true"></i> Weekly points</span></div>
        <div class="panel-body">
            <div class="row" >
              {!!Lava::render('LineChart', 'WeekPoints', 'stocks-div',true)!!}
          </div>
      </div>
  </div>
</div>
</div>



<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default panel-black">
        <div class="panel-heading"><i class="fa fa-list-ol" aria-hidden="true"></i> Top sellers for 
                    @if( $affiliate->pos()->exists() && $affiliate->pos->partner()->exists() )
                    {{$affiliate->pos->partner()->first()->name}}
                    @else
                    <i class="fa fa-times-circle" aria-hidden="true"></i> NONE
                    @endif

            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped datatableIndex">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Affiliate</th>
                                    <th>POS</th>
                                     <th>M</th>
                                     <th>Q</th>
                                     <th>C</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topsellers as $seller)
                                <tr>
                                    <td></td>
                                    <td>{{$seller->name}}</td>
                                    <td>{{$seller->pos->name}}</td>
                                    <td>{{$seller->resultm}}</td>
                                    <td>{{$seller->resultq}}</td>
                                    <td>{{$seller->resultc}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-default panel-black">
        <div class="panel-heading"><i class="fa fa-list-ol" aria-hidden="true"></i> Top POS for 
                    @if( $affiliate->pos()->exists() && $affiliate->pos->partner()->exists() )
                    {{$affiliate->pos->partner()->first()->name}}
                    @else
                    <i class="fa fa-times-circle" aria-hidden="true"></i> NONE
                    @endif
        </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-striped datatableIndex">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="never"></th>
                                    <th>POS</th>
                                    <th>M</th>
                                    <th>Q</th>
                                    <th>C</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topposes as $pos)
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>{{$pos->name}}</td>
                                    <td>{{$pos->resultm}}</td>
                                    <td>{{$pos->resultq}}</td>
                                    <td>{{$pos->resultc}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
@endsection
