        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-warning">

                @if(!$editOrCreateCategory->id)
                        <div class="panel-heading">Add new category</div>
                        <div class="panel-body">
                        <form role="form" method="POST" class="form" action="{{URL::to('categories')}}">
                @else
                        <div class="panel-heading">Edit category {{$editOrCreateCategory->name}}</div>
                        <div class="panel-body">
                        <form role="form" method="POST" class="form" action="{{URL::to('categories/'.$editOrCreateCategory->id)}}">
                        {{method_field("PUT")}}
                @endif

                            {{csrf_field()}}

                            <div class="form-group">
                                <label for="categoryname">Category name</label>
                                <input type="text" name="categoryname" class="form-control" id="categoryname" autocomplete="off" 
                                autofocus="autofocus"  
                                value="{{$editOrCreateCategory->name}}"/>

                            </div>

                            <hr />
                            <div class="pull-right">
                              <a href="{{URL::to('categories')}}" class="btn btn-default">CANCEL</a>
                              @if($editOrCreateCategory->id)
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

        var jscategorieslist=[
        @foreach($categories as $category)
        "{{$category->name}}",
        @endforeach
        ];

        // typehead bootstrap
        // https://github.com/bassjobsen/Bootstrap-3-Typeahead
        $("#categoryname").typeahead({

            source: jscategorieslist,
            matcher: tmkTypeheadMatchAnyKw,

        });


    </script>
@endpush
