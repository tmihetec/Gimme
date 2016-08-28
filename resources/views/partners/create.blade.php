        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-warning">

                @if(is_null($editOrCreatePartner->id))
                    @if($createnew)
                        <div class="panel-heading">Add new partner</div>
                        <div class="panel-body">
                    @else
                        <div class="panel-heading muted">Add new partner</div>
                        <div class="panel-body muted">
                    @endif
                    <form role="form" method="POST" class="form" action="{{URL::to('partners')}}">
                @else
                    <div class="panel-heading">Edit partner {{$editOrCreatePartner->name}}</div>
                    <div class="panel-body">
                    <form role="form" method="POST" class="form" action="{{URL::to('partners/'.$editOrCreatePartner->id)}}">
                    {{method_field("PUT")}}
                @endif
                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="partnername">Partner name</label>
                                <input type="text" name="partnername" class="form-control" id="newpartnerinput" autocomplete="off" 

                                @if(is_null($createnew) )
                                autofocus="autofocus"  
                                @endif

                                value="{{$editOrCreatePartner->name}}"/>

                            </div>

                            <hr />
                            <div class="pull-right">
                              <a href="{{URL::to('partners')}}" class="btn btn-default">CANCEL</a>
                              @if(!$createnew)
                                  <button type="reset"  class="btn btn-default">RESET</button>
                              @endif
                              <button type="submit" class="btn btn-danger">SAVE</button>
                          </div>


                      </form>


                  </div> <!-- panel body -->
              </div> <!-- panel -->


          </div> <!-- col -->

          <div class="col-md-8">
            <div class="panel panel-warning">
                
                @if(is_null($editOrCreatePos->id))
                    @if($createnew)
                        <div class="panel-heading">Add new point of sale</div>
                        <div class="panel-body">
                    @else
                        <div class="panel-heading muted">Add new point of sale</div>
                        <div class="panel-body muted">
                    @endif
                    <form role="form" method="POST" class="form" action="{{URL::to('partners/pos/')}}">
                @else
                    <div class="panel-heading">Edit POS {{$editOrCreatePos->name}}</div>
                    <div class="panel-body">
                    <form role="form" method="POST" class="form" action="{{URL::to('partners/pos/'.$editOrCreatePos->id)}}">
                    {{method_field("PUT")}}
                @endif

                        {{csrf_field()}}

<div class="row">
                            <div class="col-sm-5">
                                    <label for="newpospartner">POS partner name</label>
                                    <select name="newpospartner" class="form-control makethemselect2" >
                                        <option></option>
                                        @foreach($partnerslist as $partnerid=>$partnername)                                    
                                        <option
                                        value="{{$partnerid}}"
                                        @if ($partnerid == $editOrCreatePos->partner_id) )
                                        selected="selected" 
                                        @endif
                                        >{{$partnername}}</option>
                                        @endforeach
                                    </select>                    
                                </div>


                                <div class="col-sm-7">
                                    <label for="newposname">POS name</label>
                                    <input type="text" name="newposname" class="form-control" value="{{$editOrCreatePos->name}}" />
                                </div>
</div>

                             <hr />
                             <div class="pull-right">
                              <a href="{{URL::to('partners')}}" class="btn btn-default">CANCEL</a>
                              @if(!$createnew)
                                  <button type="reset"  class="btn btn-default">RESET</button>
                              @endif
                              <button type="submit" class="btn btn-danger">SAVE</button>
                              </div>


              </form>


          </div> <!-- panel body -->
      </div> <!-- panel -->


  </div> <!-- col -->

</div> <!-- row -->



<!-- page related js -->

@push('pageRelatedJavascript')
    <script type="text/javascript" >

        var jspartnerlist=[
        @foreach($partnerslist as $partner)
        "{{$partner}}",
        @endforeach
        ];

        // typehead bootstrap
        // https://github.com/bassjobsen/Bootstrap-3-Typeahead
        $("#newpartnerinput").typeahead({

            source: jspartnerlist,
            matcher: tmkTypeheadMatchAnyKw,

        });


    </script>
@endpush
