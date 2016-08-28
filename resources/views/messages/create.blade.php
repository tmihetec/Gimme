@extends('layouts.app')

@section('content')

<div class="container">

@include('layouts.errnmsgs')

{{-- DODATI ATTACHMENTS!! --}}

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-warning">
                  <div class="panel-heading">Compose new message </div>
                  <div class="panel-body">
                  <form class="form" method="post" role="form" action="{{URL::to('messages')}}" >

                    {{csrf_field()}}
  

                    <div class="row">

                      <div class="col-md-8"> 
  
                        <div class="form-group">
                          <label class="control-label">Title:</label>
                            <input class="form-control" name="title" value="" type="text" />
                        </div>

                        <div class="form-group">
                          <label class="control-label">Body:</label>
                            <textarea class="form-control" name="body" rows="6"></textarea>
                        </div>

                      </div>

                      <div class="col-md-4"> 

                            <div class="form-group">
                              <label class="control-label">Class:</label>
                                <select class="form-control" name="class">
                                  <option value="danger">Info</option>
                                  <option value="alert">Alert</option>
                                </select>
                            </div>


                              <label class="control-label">Recipients: </label>

                            <div class="form-group">
                                <select class="form-control makethemselect2" multiple="multiple" name="msgrecipientsPartners" id="msgrecipientsPartners"  data-placeholder="All">
                                  @foreach($partnerlist as $id=>$name)
                                    <option value="{{$id}}">{{$name}}</option>
                                  @endforeach                                  
                                </select>

                              </div>

                            <div class="form-group">
                                <select class="form-control makethemselect2" multiple="multiple" name="msgrecipientsPoses" id="msgrecipientsPoses"  data-placeholder="POS" disabled="disabled"></select>

                              </div>

                            <div class="form-group">
                                <select class="form-control makethemselect2" multiple="multiple" name="msgrecipientsUsers" id="msgrecipientsUsers" data-placeholder="Affiliate" disabled="disabled"></select>

                              </div>

                        </div>


                      </div>

                    <hr />
                    <div class="col-sm-12">
                      <div class="pull-right">
                      <button class="btn btn-primary" type="submit">Send message</button> 
                      <button class="btn btn-primary" type="submit" disabled="disabled">Send later</button>
                      </div>
                    </div>

                    </div><!-- row -->
                  </form>
                  </div>
            </div>

        </div>
    </div>
@endsection
