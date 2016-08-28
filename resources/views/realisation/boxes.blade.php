    <div class="row" >

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
