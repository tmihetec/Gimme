        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">

                @if(!$editOrCreateBrand->id)
                        <div class="panel-heading">Add new brand</div>
                        <div class="panel-body">
                        <form role="form" method="POST" class="form" action="{{URL::to('brands')}}">
                @else
                        <div class="panel-heading">Edit brands {{$editOrCreateBrand->name}}</div>
                        <div class="panel-body">
                        <form role="form" method="POST" class="form" action="{{URL::to('brands/'.$editOrCreateBrand->id)}}">
                        {{method_field("PUT")}}
                @endif

                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="brandname">Brand name</label>
                                <input type="text" name="brandname" class="form-control" id="brandname" autocomplete="off" 
                                autofocus="autofocus"  
                                value="{{$editOrCreateBrand->name}}"/>

                            </div>

                            <hr />
                            <div class="pull-right">
                              <a href="{{URL::to('brands')}}" class="btn btn-default">CANCEL</a>
                              @if($editOrCreateBrand->id)
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

        var jsbrandslist=[
        @foreach($brands as $brand)
        "{{$brand->name}}",
        @endforeach
        ];

        // typehead bootstrap
        // https://github.com/bassjobsen/Bootstrap-3-Typeahead
        $("#brandname").typeahead({

            source: jsbrandslist,
            matcher: tmkTypeheadMatchAnyKw,

        });


    </script>
@endpush
