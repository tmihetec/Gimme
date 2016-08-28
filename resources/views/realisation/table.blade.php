                    	<table class="table table-striped table-hover table-condensed  realisationtable" id="realisationTable">
                    	<thead>
                    		<tr>
                    			<th>brand</th>
                    			<th>category</th>
                    			<th>item</th>
                    			<th>date</th>
                    			<th>invoice</th>
                    			<th>points</th>
                    			<th></th>
                    		</tr>
                    	</thead>
                         <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align:right">Sum:</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                         </tfoot>
                    	<tbody>
                    		@foreach($details as $item)
                    			<tr>
                    				<td>{{$item->brand->name}}</td>
                    				<td>{{$item->category->name}}</td>
                    				<td>{{$item->name}}</td>
                    				<td>{{$item->pivot->date}}</td>
                    				<td>{{$item->pivot->invoice}}</td>
                    				<td>{{$item->pivot->points}}</td>
                    				<td>
										@if($item->locked==0)
											<a class="btn btn-xs btn-danger deleteRealisationItem" data-placement="left" title="Delete item?" data-delete="{{ csrf_token() }}" data-id="{{$item->pivot->id}}"><i class="glyphicon glyphicon-trash"></i></a>
										@endif
                    				</td>
                    			</tr>
                    		@endforeach
                    	</tbody>
                         </table>
