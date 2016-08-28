    @extends('layouts.app')

    @section('content')

    <div class="container">

        @include('layouts.errnmsgs')

        @if($editOrCreatePartner || $editOrCreatePos)
            @include('partners.create')
        @endif

        <!-- list partners --> {{-- INDEX --}}
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Partners list <a class="pull-right" href="{{URL::to('partners/create')}}" ><i class="fa fa-plus-circle"  title="Add new POS"></i> Add new Partner/POS</a> </div>

                    <div class="panel-body">


                        <table class="table datatable table-striped table-bordered table-hover dt-responsive" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Partner</th>
                                    <th rowspan="2">M</th>
                                    <th rowspan="2">Q</th>
                                    <th rowspan="2">C</th>
                                    <th style="text-align:center;" colspan="3">partner score relative to all other partners</th>
                                    <th rowspan="2"></th>
                                </tr>
                                <tr>
                                    <th title="% of all Partners">M%</th>
                                    <th title="% of all Partners">Q%</th>
                                    <th style="border-right:1px solid #ddd;" title="% of all Partners">C%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($partners as $partner)
                                <tr>
                                    <td>{{$partner->name}}</td>
                                    <td>{{$partner->resultm}}</td>
                                    <td>{{$partner->resultq}}</td>
                                    <td>{{$partner->resultc}}</td>
                                    <td>{!! ($totalm > 0) ? number_format((float) $partner->resultm / $totalm * 100 ,2, ',','' ) : 0 !!}</td>
                                    <td>{!! ($totalq > 0) ? number_format((float) $partner->resultq / $totalq * 100 ,2, ',','' ) : 0 !!}</td>
                                    <td>{!! ($totalc > 0) ? number_format((float) $partner->resultc / $totalc * 100 ,2, ',','' ) : 0 !!}</td>
                                    <td><a href="{{URL::to('partners/'.$partner->id.'/edit')}}" title="Edit Partner" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square"></i></a>
                                    <a class="btn btn-xs btn-danger deleteItem"  title="Delete item?" data-token="{{ csrf_token() }}" data-myhref="{{URL::to('partners/'.$partner->id)}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- panel body -->
                </div> <!-- panel -->


                <div class="panel panel-default">
                    <div class="panel-heading">POS list <a class="pull-right" href="{{URL::to('partners/create')}}" ><i class="fa fa-plus-circle"  title="Add new POS"></i> Add new Partner/POS</a> </div>

                    <div class="panel-body">

                        <table class="table datatable table-striped table-bordered table-hover dt-responsive" width="100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">Partner</th>
                                    <th rowspan="2">POS</th>
                                    <th rowspan="2">M</th>
                                    <th rowspan="2">Q</th>
                                    <th rowspan="2">C</th>
                                    <th  style="text-align:center;" colspan="3" title="relative to partner's POSes">relative to partner's POSes</th>
                                    <th  style="text-align:center;" colspan="3" title="relative to all POS">relative to all POSes</th>
                                    <th rowspan="2"></th>
                                </tr>
                                <tr>
                                    <th title="% of Partners POS">M%</th>
                                    <th title="% of Partners POS">Q%</th>
                                    <th title="% of Partners POS">C%</th>
                                    <th title="% of all POS">M%</th>
                                    <th title="% of all POS">Q%</th>
                                    <th  style="border-right:1px solid #ddd;" title="% of all POS">C%</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($poses as $pos)
                                <tr>
                                    <td>{!!($pos->partner) ? $pos->partner->name : '<span class="text-danger">Undefined</span>'!!}</td>
                                    <td>{{$pos->name}}</td>
                                    <td>{{$pos->resultm}}</td>
                                    <td>{{$pos->resultq}}</td>
                                    <td>{{$pos->resultc}}</td>
                                    <td>{!! ($pos->partner->resultm > 0) ? number_format((float) $pos->resultm / $pos->partner->resultm * 100 ,2, ',','' ) : 0 !!}</td>
                                    <td>{!! ($pos->partner->resultq > 0) ? number_format((float) $pos->resultq / $pos->partner->resultq * 100 ,2, ',','' ) : 0 !!}</td>
                                    <td>{!! ($pos->partner->resultc > 0) ? number_format((float) $pos->resultc / $pos->partner->resultc * 100 ,2, ',','' ) : 0 !!}</td>

                                    <td>{!! ($totalm > 0) ? number_format((float) $pos->resultm / $totalm * 100 ,2, ',','' ) : 0 !!}</td>
                                    <td>{!! ($totalq > 0) ? number_format((float) $pos->resultq / $totalq * 100 ,2, ',','' ) : 0 !!}</td>
                                    <td>{!! ($totalc > 0) ? number_format((float) $pos->resultc / $totalc * 100 ,2, ',','' ) : 0 !!}</td>

                                    <td><a href="{{URL::to('partners/pos/'.$pos->id.'/edit')}}" title="Edit POS" class="btn btn-primary btn-xs"> <i class="fa fa-pencil-square"></i> </a>
                                     <a class="btn btn-xs btn-danger deleteItem"  title="Delete item?" data-token="{{ csrf_token() }}" data-myhref="{{URL::to('partners/pos/'.$pos->id)}}"><i class="fa fa-trash" aria-hidden="true"></i> </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div> <!-- panel body -->

                </div> <!-- panel -->
            </div> <!-- col -->
        </div> <!-- row -->



    </div> <!-- container -->

    @endsection