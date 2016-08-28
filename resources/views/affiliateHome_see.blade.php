@extends('layouts.app')

@section('content')

<div class="container">


    @include('layouts.errnmsgs')

<div class="row"> <!-- ADD2MYSCORE -->
    <div class="col-md-12 newrealisation">
        <div class="well">


            <form id="add2myscore">
                <input type="hidden" name="_token" id="apptoken" value="{{csrf_token()}}" />                  
                <input type="hidden" id="currentuser" name="currentuser" value="{{Auth::user()->id}}" />

                <div class="input-group-lg select2-bootstrap-append" id="a2s-container">

                    <select class="form-control " id="realisationselect">
                        <option></option>
                        @foreach($items as $item)
                        <option value="{{$item->id}}" data-points="{!!($item->latestpoints) ? $item->latestpoints->points : "0" !!}" title="{{$item->name}}">{{$item->text}}</option>
                        @endforeach
                    </select>

                </div>

                <div class="text-center" style="margin-top:10px">
                <div class="btn-group btn-group-lg " role="group" aria-label="Add score">
                    
                    <button type="button" readonly ="readonly" class="btn btn-lg" id="realisation-pt-box"></button>
                    <button class="btn btn-danger btn-lg" id="realisationsubmit" type="button" >ADD TO MY SCORE
                    </button>

                </div>
                </div>
                

            </form>

        </div><!-- /.well -->
    </div><!-- /.col -->
</div><!-- /.row  - ADD2MYSCORE --> 


<div class="row">

<div class="col-md-4">

            <div class="panel panel-default panel-black">
                <div class="panel-heading"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> My scrapbook <button class="pull-right btn btn-default btn-xs" id="savebutton" type="button" disabled>Save</button> <span id="savemessage" class="pull-right"></span></div>                
                <div class="panel-body">                    
                    <noscript>JavaScript not enabled, readonly!</noscript>
                    <form>
                        <div class="form-group">
                            <textarea title="myscrapbook" name="myscrapbook" class="form-control" rows="11 " id="myscrapbook"
                            >{{$affiliate->scrapbook}}</textarea>
                        </div>
                    </form>
                </div>
            </div>

</div> <!-- druga kolona -->
<div class="col-md-4">

            <div class="row"> <!-- ROW - SCORES -->
                   <div class="col-md-12">
                    <div class="panel panel-default panel-black">
                        <div class="panel-heading"><i class="fa fa-bar-chart" aria-hidden="true"></i> <a href="{{URL::to('realisation')}}">Realisation</a> for <span class="showInnerInlineLinkOnHover">{{$affiliate->display_name}} <a href="{{URL::to("/affiliate/".$affiliate->id)}}"><i class="glyphicon glyphicon-pencil"></i></a></span></div>
                        <div class="panel-body">
                            <div class="row results">
                                <div class="col-sm-12 hidden-xs">
                                    <div class="inner bgcolor3">
                                        <div class="title">M</div>
                                        <div class="score"><span class="scoreM">{{$affiliate->formatedresultm}}</span>pt</div>
                                        <div class="description"><i class="glyphicon glyphicon-th-list"></i> <a href="{{URL::to('realisation/m')}}">realisation this month</a></div>
                                    </div>
                                </div>
                                <div class="col-sm-12 quarterlyresult">
                                    <div class="inner bgcolor2 ">
                                        <div class="title">Q</div>
                                        <div class="score"><span class="scoreQ">{{$affiliate->formatedresultq}}</span>pt</div>
                                        <div class="description"><i class="glyphicon glyphicon-th-list"></i> <a href="{{URL::to('realisation/q')}}">realisation this quarter</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- ROW - SCORES -->


</div>
<div class="col-md-4"> <!-- druga kolona - top lista -->

            <div class="panel panel-default">
                <div class="panel-heading"><i class="fa fa-list-ol" aria-hidden="true"></i> 
                    Week top scores for 
                    @if( $affiliate->pos()->exists() && $affiliate->pos->partner()->exists() )
                    {{$affiliate->pos->partner()->first()->name}}
                    @else
                    <i class="fa fa-times-circle" aria-hidden="true"></i> NONE
                    @endif
                </div>
                <div class="panel-body afftoplist">


                           <table class="table table-striped">
                               <thead>
                                  <tr>
                                     <th></th>
                                     <th>Affiliate</th>
                                     <th>POS</th>
                                     <th>Pts</th>
                                     <th>Qty</th>
                                 </tr>
                             </thead>
                             <tbody>

                                @foreach ($weektopscores as $aff)                                
                                  <tr>
                                     <td>{{$aff['rbr']}}</td>
                                     <td>{{$aff['name']}}</td>
                                     <td>{{$aff['pos']}}</td>
                                     <td>{{$aff['pts']}}</td>
                                     <td>{{$aff['qty']}}</td>
                                 </tr>
                                @endforeach

                             </tbody>
                     </table>


                </div>
            </div>

</div>





</div> <!-- row -->










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


@push('pageRelatedJavascript')

    {{--
        https://laracasts.com/lessons/broadcasting-events-in-laravel-5-1
        https://mattstauffer.co/blog/broadcasting-events-with-pusher-socket-in-laravel-5.1
        http://matthewdaly.co.uk/blog/2016/05/14/broadcasting-events-with-laravel-and-socket-dot-io/
        http://socket.io/get-started/chat/
        vue.js


        http://zrashwani.com/server-sent-events-example-laravel/#.V4ue0dKLTix
        REFRESH WEEK RESULTSA NA PREDNJOJ!        

    <script type="text/javascript">

        var pathSSE="{!!url('sse')!!}";
        var procesSEE=function(e)
        {
            console.log("aaaa"+e.data);
            // alert("da");
            // arr = JSON.parse(e.data);;
        }



        if(window.EventSource !== undefined){

         // supports eventsource object go a head...
            var es = new EventSource(pathSSE);
            es.addEventListener("message", function(e) {
                        procesSEE(e);
            }, false);

            es.addEventListener("open", function(e) {
                console.log("Connection was opened.");
            }, false);

            es.addEventListener("error", function(e) {
                console.log("Error - connection was lost.");
            }, false);


        } else {
          /* 
          // EventSource not supported, apply ajax long poll fallback
           (function poll(){
                 setTimeout(function(){
                      $.ajax({ url: pathSSE, success: function(data){
                        procesSEE(e);
                        poll();
                    }, dataType: "json"});
                  }, 30000);
            })(); 
          */
        }
    </script>
    --}}


@endpush

@endsection
