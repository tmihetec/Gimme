@extends('layouts.app')

@section('content')

<div class="container">


    @include('layouts.errnmsgs')

    <div class="row">
        <!-- <div class="col-md-10 col-md-offset-1"> -->
       <div class="col-md-12">
            <div class="panel panel-default panel-black">
                <div class="panel-heading"><i class="fa fa-bar-chart" aria-hidden="true"></i> <a href="{{URL::to('realisation')}}">Realisation</a> for <span class="showInnerInlineLinkOnHover">{{$affiliate->display_name}} <a href="{{URL::to("/affiliate/".$affiliate->id)}}"><i class="glyphicon glyphicon-pencil"></i></a></span></div>
                <div class="panel-body">
                    <div class="row results">
                        <div class="col-sm-4">
                        <div class="inner bgcolor3">
                            <div class="title">M</div>
                            <div class="score"><span class="scoreM">{{$affiliate->formatedresultm}}</span>pt</div>
                            <div class="description"><i class="glyphicon glyphicon-th-list"></i> <a href="{{URL::to('realisation/m')}}">realisation this month</a></div>
                        </div>
                        </div>
                        <div class="col-sm-4 quarterlyresult">
                        <div class="inner bgcolor2 ">
                            <div class="title">Q</div>
                            <div class="score"><span class="scoreQ">{{$affiliate->formatedresultq}}</span>pt</div>
                            <div class="description"><i class="glyphicon glyphicon-th-list"></i> <a href="{{URL::to('realisation/q')}}">realisation this quarter</a></div>
                        </div>
                        </div>
                        <div class="col-sm-4">
                        <div class="inner bgcolor1">
                            <div class="title">C</div>
                            <div class="score"><span class="scoreC">{{$affiliate->formatedresultc}}</span>pt</div>
                            <div class="description"><i class="glyphicon glyphicon-th-list"></i> <a href="{{URL::to('realisation/c')}}">complete realisation</a></div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-md-12 newrealisation">
    <div class="well">


                  <form id="add2myscore">
                    <input type="hidden" name="_token" id="apptoken" value="{{csrf_token()}}" />                  
                    <input type="hidden" id="currentuser" name="currentuser" value="{{Auth::user()->id}}" />

                    <div class="input-group input-group-lg select2-bootstrap-append" id="a2s-container">
                    
                            <select class="form-control " id="realisationselect">
                                <option></option>
                                @foreach($items as $item)
                                    <option value="{{$item->id}}" data-points="{{$item->points}}" title="{{$item->name}}">{{$item->text}}</option>
                                @endforeach
                            </select>

                            <div class="input-group-btn">
                                <div type="text" class="btn" id="realisation-pt-box"></div>
                                <button class="btn btn-danger " id="realisationsubmit" type="button" data-select2-open="select2-button-addons-single-input-group-lg">
                                    <i class="fa fa-plus-circle visible-xs"></i><span class="hidden-xs">ADD TO MY SCORE</span>
                                </button>
                            </div>
                    </div>

                </form>
                  
    </div><!-- /.row -->
    </div><!-- /.col -->
    </div><!-- /.well -->







    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default panel-black">
                <div class="panel-heading"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> My scrapbook <button class="pull-right btn btn-default btn-xs" id="savebutton" type="button" disabled>Save</button> <span id="savemessage" class="pull-right"></span></div>                
                <div class="panel-body">                    
                    <noscript>JavaScript not enabled, readonly!</noscript>
                    <form>
                        <div class="form-group">
                        <textarea title="myscrapbook" name="myscrapbook" class="form-control" rows="5" id="myscrapbook"
                        >{{$affiliate->scrapbook}}</textarea>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





<!--
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Gimme roadmap.</div>

                <div class="panel-body">

                    <pre>
                    v2:
                                0) OBJAVE!
                                1) VIDI SCORE SVOJEG POS-a
                                2) ako ima, vidi score TOP PARENTA!
                                3) pošalji poruku adminu!
                                4) badges!! napraviti bazu (tab) sa značkama, "JEE najbolji na POS/Principal ovaj tjedan"... danas najbolji... i tak, možda da im se daje koji extra  point za tipa 5-in-a-row značaka... (level up!)

                     
                    </pre>
                </div>
            </div>
        </div>
    </div>
-->

</div>
@endsection
