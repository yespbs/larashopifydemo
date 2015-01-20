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
	
	'api_key'       => '7f54d10643aa327447448a2cb5e87ce0',
	'secret_key'    => 'f2458af93330d87bf961244cfac3a81f',	
	'redirect_uri'  => 'http://localhost/laravel-shopify/develop/public/stores/connect',
	'scopes'        => ['read_orders','read_products','read_customers'],

);
