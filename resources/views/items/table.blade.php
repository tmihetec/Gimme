
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Incentive items list

                    <div class="pull-right">
                    <a href="{{URL::to('items/create')}}" ><i class="fa fa-plus-circle"  title="Add new item"></i> Add new item </a>&nbsp;
                    </div>

                </div>

                <div class="panel-body">
                   
                <table class="table itemstable table-striped table-bordered table-hover dt-responsive" width="100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <th>active</th>
                            <th>sku</th>
                            <th>pn</th>
                            <th>category</th>
                            <th>brand</th>
                            <th>pts</th>
                            <th title="score quantity">sqty</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr 
                        @if(!$item->active)
                            class="strikeout"
                        @endif
                        >
                            <td>{{$item->id}}</td>
                            <td>{{$item->name}}</td>
                            <td>
                                @if($item->active)
                                    YES
                                @else 
                                    NO
                                @endif
                            </td>
                            <td>{{$item->sku}}</td>
                            <td>{{$item->pn}}</td>
                            <td>{!!($item->category) ? $item->category->name : '<span class="text-danger">Undefined</span>'!!}</td>
                            <td>{!!($item->brand) ? $item->brand->name : '<span class="text-danger">Undefined</span>'!!}</td>
                            <td>{!!($item->latestpoints) ? $item->latestpoints->points : "0" !!}</td>
                            <td>{{$item->scores}}</td>
                            <td class="tools">

                                <div class="btn-group" role="group" aria-label="item tools">
                                        <a class="btn btn-xs btn-primary" href="{{URL::to('items/'.$item->id.'/edit')}}"><i aria-hidden="true" class="fa fa-pencil-square"></i></a>

                                    @if($item->active)
                                        <a class="btn btn-xs btn-warning postAction"  title="Deactivate item?" data-token="{{ csrf_token() }}" data-myhref="{{URL::to('items/toggleActive/'.$item->id)}}"><i class="fa fa-minus-square" aria-hidden="true"></i></a>
                                    @else
                                        <a class="btn btn-xs btn-success postAction"  title="Activate item?" data-token="{{ csrf_token() }}" data-myhref="{{URL::to('items/toggleActive/'.$item->id)}}"><i class="fa fa-plus-square" aria-hidden="true"></i></a>
                                    @endif

                                    @if ($item->scores > 0)
                                        <a class="btn btn-xs btn-danger disabled"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    @else 
                                        <a class="btn btn-xs btn-danger deleteItem"  title="Delete item?" data-token="{{ csrf_token() }}" data-myhref="{{URL::to('items/'.$item->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    @endif
                                
                                </div>

                            </td>
                        </tr>
                    @endforeach
                       </tbody>
                   </table>

                </div>

            </div>
        </div>
    </div>
