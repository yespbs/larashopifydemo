<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Shopify
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/
	
	'api_key'       => '1e02bf129dce9915d49d9443b54ad43f',
	'shared_secret' => 'fa4400b7ef1743b8c270bd2a4557f024',	
	'redirect_uri'  => 'http://localhost/laravel-shopify/develop/public/stores/connect',
	'scopes'        => 'read_orders,read_products,read_customers',

);
