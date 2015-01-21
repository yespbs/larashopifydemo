<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::get('/', function()
{
	return View::make('hello');
});*/


Route::match(array('get','post'), 'stores/{id}/webhooks', [ 'uses' => 'StoreController@anyWebhooks', 'as' => 'store.webhooks' ]); 

Route::controller('stores'     , 'StoreController');
//Route::controller('webhooks'   , 'WebhookController');

/**
 * Default 
 */
 Route::get('/', 'StoreController@anyIndex');
