@extends('layouts.app')

@section('content')


<div class="container">

    @include('layouts.errnmsgs')



    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                  
                    @if(is_null($editOrCreateItem->id))
                        <div class="panel-heading">Add new Item</div>
                        <div class="panel-body">
                        <form role="form" method="POST" class="form" action="{{URL::to('items')}}">
                    @else
                        <div class="panel-heading">Edit item {{$editOrCreateItem->name}}</div>
                        <div class="panel-body">
                        <form role="form" method="POST" class="form" action="{{URL::to('items/'.$editOrCreateItem->id)}}">
                        {{method_field("PUT")}}
                    @endif
                    {{csrf_field()}}


                    <div class="row">

                    <div class="col-sm-7">

                      <div class="form-group">
                          <label for="name">Item name</label>
                          <input type="text" name="name" class="form-control" id="itemname" autocomplete="off"      value="{{$editOrCreateItem->name}}"/>
                      </div>
                      <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label for="pn">Item PN</label>
                                <input type="text" name="pn" class="form-control" id="itempn" autocomplete="off"      value="{{$editOrCreateItem->pn}}"/>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label for="sku">Item SKU</label>
                                <input type="text" name="sku" class="form-control" id="itemsku" autocomplete="off"      value="{{$editOrCreateItem->sku}}"/>
                            </div>
                          </div>
                      </div> <!-- row -->
                      <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label for="nc">Item purchase price (use "." for decimal)</label>
                                <input type="text" name="nc" class="form-control" id="itemnc" autocomplete="off"      value="{{$editOrCreateItem->nc}}"/>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group">
                                <label for="points">Item incentive points</label>
                                <input type="text" name="points" class="form-control" id="itempoints" autocomplete="off"      value="{!!($editOrCreateItem->latestpoints) ? $editOrCreateItem->latestpoints->points : "0" !!}"/>
                            </div>
                          </div>
                      </div> <!-- row -->

                    </div> <!-- prva kolona -->


                    <div class="col-sm-5">

                      <div class="form-group">
                          <label for="category">Item category</label>
                          <select name="category" class="form-control makethemselect2" id="itemcategory">
                              <option></option>
                              @foreach($categories as $category)
                              <option value="{{$category->id}}" 
                                  @if($editOrCreateItem->category_id == $category->id)
                                      selected="selected"  
                                  @endif
                              >{{$category->name}}</option>
                              @endforeach
                          </select>
                      </div>

                      <div class="form-group">
                          <label for="brand">Item brand</label>
                          <select name="brand" class="form-control makethemselect2" id="itembrand">
                              <option></option>
                              @foreach($brands as $brand)
                              <option value="{{$brand->id}}" 
                                  @if($editOrCreateItem->brand_id == $brand->id)
                                      selected="selected"  
                                  @endif
                              >{{$brand->name}}</option>
                              @endforeach
                          </select>
                      </div>


                        <div class="form-group" >
                          <label for="active">Active:</label>
                            <select name="active" class="form-control">
                                <option value="1">YES</option>
                                <option value="0" 
                                    @if($editOrCreateItem->active !== 1 && !$createnew)
                                        selected="selected"  
                                    @endif
                                >NO</option>
                            </select>
                        </div>



                    </div>


                    </div>

                         <hr />
                         <div class="pull-right">
                            <a href="{{URL::to('items')}}" class="btn btn-default">CANCEL</a>
                            @if(!$createnew)
                              <button type="reset"  class="btn btn-default">RESET</button>
                            @endif
                            <button type="submit" class="btn btn-danger">SAVE</button>
                          </div>

                    </form>
                    </div>

            </div>
        </div>
    </div> <!-- row -->


    @include('items.table')


</div>



@stop