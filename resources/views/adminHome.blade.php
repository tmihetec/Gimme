@extends('layouts.app')

@section('content')

<div class="container">

    @include('layouts.errnmsgs')


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Admin dashboard</div>

                <div class="panel-body">

{{-- 

                <div class="row ">
                    <div class="col-sm-4 col-xs-6">
                        <div class="infobox"><strong class="ib_title"><a href="/salesactions/10">Active sales action</a></strong><span class="ib_value">NEKA akcija (01.07.2016)</span></div>
                    </div>
                    <div class="col-sm-4 col-xs-6">
                        <div class="infobox"><strong class="ib_title"><a href="/salesactions/10">ukupno proizvoda s bodovima</a></strong><span class="ib_value">97</span></div>
                    </div>
                    <div class="col-sm-4 col-xs-6 infobox">
                        <div class="infobox"><strong class="ib_title"><a href="/salesactions/10">ukupno affiliate</a></strong><span class="ib_value">43</span></div>
                    </div>
                </div>

                <hr />
--}}

{{-- //GRAF///////////////////////////////////////////////////////////////////////////////////////////////////// --}}


                 <div class="row ">
                 <div class="col-md-12 ">
                    <div class="panel panel-default panel-black">
                        
                        <div class="panel-body">
                            <div class="row" >
                              {!!Lava::render('LineChart', 'PartnersWeekPoints', 'stocks-div',true)!!}
                            </div>
                        </div>
                    </div>
                </div>
                </div>


{{-- //MESSAGES///////////////////////////////////////////////////////////////////////////////////////////////////// --}}

                <div class="row">

                    <div class="col-md-12">

                    
                    <div class="panel panel-default panel-black">
                        <div class="panel-heading"><i class="fa fa-envelope" aria-hidden="true"></i> Messages radar</span></div>
                        <div class="panel-body">
                            <div class="row" >
                    stare poruke (broj nepročitanih! - link na popis - meni "poruke")
                            </div>
                        </div>
                    </div>

                    </div>


                </div>                


{{-- //ANALYZE///////////////////////////////////////////////////////////////////////////////////////////////////// --}}

                <hr />

                <!-- CHAINED SELECT - ANALYZE -->
                <form class="form" role="form">
                <div class="row">

                    <div class="col-sm-3">
                        <select class="form-control" id="analyticsSelectPartners">
                            <option value="0">All partners</option>
                            @foreach($partnerlist as $id=>$name)
                                <option value="{{$id}}">{{$name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <select class="form-control" id="analyticsSelectPOSes" disabled="disabled" placeholder="POS"></select>
                    </div>

                    <div class="col-sm-3">
                        <select class="form-control" id="analyticsSelectUsers" disabled="disabled" placeholder="User"></select>
                    </div>

                    <div class="col-sm-3">
                        <button class="btn btn-primary btn-block">Analyze</button>
                    </div>
                
                </div>
                <hr />
                </form> <!-- chained select -->

{{-- //TOP POS///////////////////////////////////////////////////////////////////////////////////////////////////// --}}

            <div class="row ">
                <div class="col-md-12 ">
                    <div class="panel panel-default panel-black">
                        <div class="panel-heading"><i class="fa fa-list-ol" aria-hidden="true"></i> Top POSes</span></div>
                        <div class="panel-body">
                            <div class="row" >
                            <div class="col-sm-12">
                        <table class="table table-striped table-hover table-condensed table-bordered adminDashDT">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>partner</th>
                                <th>pos</th>
                                <th>W</th>
                                <th>M</th>
                                <th>Q</th>
                            </tr>
                        </thead>
                         <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align:right">Sum:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                         </tfoot>
                        <tbody>
                            @foreach($poses as $pos)
                                <tr>
                                    <td></td>
                                    <td>{{$pos->partner->name}}</td>
                                    <td>{{$pos->name}}</td>
                                    <td>{{$pos->resultw}}</td>
                                    <td>{{$pos->resultm}}</td>
                                    <td>{{$pos->resultq}}</td>
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


{{-- //TOP AFFILIATE///////////////////////////////////////////////////////////////////////////////////////////////////// --}}

            <div class="row ">
                <div class="col-md-12 ">
                    <div class="panel panel-default panel-black">
                        <div class="panel-heading"><i class="fa fa-list-ol" aria-hidden="true"></i> Top affiliate</span></div>
                        <div class="panel-body">
                            <div class="row" >
                            <div class="col-sm-12">
                        <table class="table table-striped table-hover table-condensed table-bordered adminDashDT2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>partner</th>
                                <th>pos</th>
                                <th>affiliate</th>
                                <th>W</th>
                                <th>M</th>
                                <th>Q</th>
                            </tr>
                        </thead>
                         <tfoot>
                                <tr>
                                    <th colspan="4" style="text-align:right">Sum:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                         </tfoot>
                        <tbody>
                            @foreach($affiliates as $affiliate)
                                <tr>
                                    <td></td>
                                    <td>{{$affiliate->pos->partner->name}}</td>
                                    <td>{{$affiliate->pos->name}}</td>
                                    <td>{{$affiliate->firstname}} {{$affiliate->lastname}}</td>
                                    <td>{{$affiliate->resultw}}</td>
                                    <td>{{$affiliate->resultm}}</td>
                                    <td>{{$affiliate->resultq}}</td>
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


{{-- //TOP ITEMS///////////////////////////////////////////////////////////////////////////////////////////////////// --}}


            <div class="row ">
                <div class="col-md-12 ">
                    <div class="panel panel-default panel-black">
                        <div class="panel-heading"><i class="fa fa-list-ol" aria-hidden="true"></i> Top incentive items</span></div>
                        <div class="panel-body">
                            <div class="row" >
                            <div class="col-sm-12">
                        <table class="table table-striped table-hover table-condensed table-bordered adminDashDT2">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>item</th>
                                <th title="current points">pts</th>
                                <th>W Qty</th>
                                <th>M Qty</th>
                                <th>Q Qty</th>
                                <th>W Pts</th>
                                <th>M Pts</th>
                                <th>Q Pts</th>
                            </tr>
                        </thead>
                         <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align:right">Sum:</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                         </tfoot>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td></td>
                                    <td>{{$item->name}}</td>
                                    <td>{!!($item->latestpoints) ? $item->latestpoints->points : "0" !!}</td>
                                    <td>{{$item->realisationsdataw->count()}}</td>
                                    <td>{{$item->realisationsdatam->count()}}</td>
                                    <td>{{$item->realisationsdataq->count()}}</td>
                                    <td>{{$item->realisationsdataw->sum('points')}}</td>
                                    <td>{{$item->realisationsdatam->sum('points')}}</td>
                                    <td>{{$item->realisationsdataq->sum('points')}}</td>
                                    
                            @endforeach
                        </tbody>
                         </table>

</div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>












{{--

lijevo: new message (textbox, type, kome? (chained) )

<pre>
v2:
                    - ADD OBJAVE
                        - BULK ASIGN CATEGORIES AND BRANDS 
                        - IMPORT ITEMS TO UNASIGNED OR ASIGN CATEGORY AND/OR BRAND
                    - ADD/EDIT SPECIALS (proširiti glavni user addpoints select sa "+SPECIALSpt" - i negdje označiti artikle ak se na njih odnosi)
                    partner se veže uz brand(ove) ili sve brandove i kategoriju(e) i sve kategorije
                    (reporti...)
                    - pregled poruka affiliatea (user, partner, datum, poruka...)
</pre>

--}}
                </div>
            </div>
        </div>
    </div>

</div> <!--container -->
@endsection
