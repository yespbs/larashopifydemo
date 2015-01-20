@extends('layouts.default')

@section('content')
	<div style="padding:10px">
	<h3>Stores</h3>
		<table class="table table-striped">
	  		<thead>
	  			<tr>
		  			<th>Sl.</th>
		  			<th>Store URL</th>
		  			<th></th>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			<tr>
	  				<td></td>
	  				<td></td>
	  				<td></td>
	  			</tr>

	  			<tr>
	  				<td></td>
	  				<td></td>
	  				<td></td>
	  			</tr>

	  			<tr>
	  				<td></td>
	  				<td></td>
	  				<td></td>
	  			</tr>

	  		</tbody>
		</table>
	
		<hr>
		<h4>Add a store</h4>
		<form class="form-inline">
			<div class="form-group">
				<label for="exampleInputName2">Store URL</label><br>
				<input type="text" class="form-control" id="store_name" name="store_name" placeholder="store name"><b>.myshopify.com</b>
				<button type="button" class="btn btn-default" onclick="shopify_authorize()">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add
				</button>
			</div>			
		</form>
	</div>
	<script type="text/javascript">
		shopify_authorize=function(){
			store_name = jQuery('#store_name').val();
			window.location.href = "https://" + store_name + ".myshopify.com/admin/oauth/authorize?client_id={{{ Config::get("shopify.api_key") }}}&scope={{{ implode(',', Config::get("shopify.scopes")) }}}&redirect_uri={{{ Config::get("shopify.redirect_uri") }}}";
		}	
	</script>
@stop