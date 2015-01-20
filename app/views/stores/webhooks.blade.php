@extends('layouts.default')

@section('content')
	<div style="padding:10px">
		<h3>Webhooks</h3>
		<table class="table table-striped">
	  		<thead>
	  			<tr>
		  			<th>Id#</th>
		  			<th>Topic</th>
		  			<th>Address</th>
		  			<th>Format</th>
		  			<th>Created</th>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			@if( count($webhooks) == 0 )
	  				<tr>
		  				<td colspan="5">no webhooks</td>		  				
		  			</tr>
	  			@else
	  				@foreach($webhooks as $webhook)
	  					<tr>
			  				<td>{{{ $webhook['id'] }}}</td>
			  				<td>{{{ $webhook['topic'] }}}</td>
			  				<td>{{{ $webhook['address'] }}}</td>			  				
			  				<td>{{{ $webhook['format'] }}}</td>
			  				<td>{{{ date('m/d/Y H:i:s', strtotime($webhook['created_at'])) }}}</td>
			  			</tr>
	  				@endforeach
	  			@endif
	  			
	  		</tbody>
		</table>
	
		<hr>
		<h4>Add a webhook</h4>
		
		{{ Form::open( array( 'url'=>url('stores/webhook-create'), 'method'=>'post', 'name'=>'webhook-form','id'=>'webhook-form',
    	'class'=>'form-horizontal') ) }}
		  <div class="form-group">
		    <label for="inputEmail3" class="col-sm-2 control-label">Topic</label>
		    <div class="col-sm-10">
		      <input type="text" name="topic" id="topic" class="form-control" placeholder="orders/create">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">Address</label>
		    <div class="col-sm-10">
		      <input type="text" name="address" id="address" class="form-control" placeholder="address">
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="inputPassword3" class="col-sm-2 control-label">Format</label>
		    <div class="col-sm-10">
		      {{ Form::select('format', $format_options, 'json', array('class'=>'form-control') ) }}
		    </div>
		  </div>
		  <div class="form-group">
		    <div class="col-sm-offset-2 col-sm-10">
		      	<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
				</button>

				<button type="button" class="btn btn-default" onclick="window.location.href='{{{ url('stores') }}}'">
					<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> Back
				</button>
		    </div>
		  </div>
		{{ Form::hidden('act', 'create_webhook') }}
		{{ Form::hidden('store_id', $store->id) }}
		{{ Form::close() }} 
	</div>
	<script type="text/javascript">
			
	</script>
@stop