<?php

class StoreController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /store
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		//
		// echo 'index';

		$data = array();

		return View::make('stores.index', $data);
	}

	/**
	 * Display a listing of the resource.
	 * GET /store
	 *
	 * @return Response
	 */
	public function anyConnect()
	{
		//
		echo 'connect';

		$post = Input::get();
		pr( $post );

		

		/*if (!isset($_GET['code'])) {

		    // If we don't have an authorization code then get one
		    $authUrl = $provider->getAuthorizationUrl();
		    $_SESSION['oauth2state'] = $provider->state;
		    \Session::put('oauth2state', $provider->state);
		    header('Location: '.$authUrl);
		    exit;

		// Check given state against previously stored one to mitigate CSRF attack
		} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

		    unset($_SESSION['oauth2state']);
		    exit('Invalid state');

		} else {*/

			if( Input::has('code') && Input::has('shop') ){

				$code = Input::get('code');
				$shop = Input::get('shop');

				try{
					$provider = new \LaraShopifyDemo\Services\OAuth2\Shopify([
					    'clientId'     => Config::get("shopify.api_key"),
					    'clientSecret' => Config::get("shopify.secret_key"),
					    'redirectUri'  => Config::get("shopify.redirect_uri"),
					    'scopes'       => Config::get("shopify.scopes"),
					]);

					$provider->setStore( $shop );

				    // Try to get an access token (using the authorization code grant)
				    $token = $provider->getAccessToken('authorization_code', [
				        'code' => $code
				    ]);

				   /* // If you are using Eventbrite you will need to add the grant_type parameter (see below)
				    $token = $provider->getAccessToken('authorization_code', [
				        'code' => $code,
				        'grant_type' => 'authorization_code'
				    ]);*/

				    // Optional: Now you have a token you can look up a users profile data
				    /*try {
				    	// token
				    	//print '<br>access token: ' . $token;
				        // We got an access token, let's now get the user's details
				        $userDetails = $provider->getUserDetails( $token );

				        // Use these details to create a new profile
				        println( sprintf('Hello %s!', $userDetails->firstName) );

				    } catch (Exception $e) {

				    	println( 'error1: '. $e->getMessage());
				        // Failed to get user details
				        //exit('Oh dear...');
				    }*/

				    // Use this to interact with an API on the users behalf
				    println( 'accessToken: '. $token->accessToken);

				    // Use this to get a new access token if the old one expires
				    println( 'refreshToken: '. $token->refreshToken);

				    // Number of seconds until the access token will expire, and need refreshing
				    println( 'expires: ' . $token->expires);
				}catch (Exception $e) {

			    	println( 'error2: '. $e->getMessage());
			        // Failed to get user details
			        //exit('Oh dear...');
			    }    
			}
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /store/create
	 *
	 * @return Response
	 */	
	public function anyUserDetails()
	{
		$post = Input::get();
		pr( $post );
	}

	public function anyRevoke()
	{
		$access_token = Config::get("shopify.secret_key");
	    $revoke_url   = "https://someshop.myshopify.com/admin/oauth/revoke";

		  $headers = array(
		    "Content-Type: application/json",
		    "Accept: application/json",
		    "Content-Length: 0",
		    "X-Shopify-Access-Token: " . $access_token
		  );

		  $handler = curl_init($revoke_url);
		  curl_setopt($handler, CURLOPT_CUSTOMREQUEST, "DELETE");
		  curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($handler, CURLOPT_HTTPHEADER, $headers);

		  $response = curl_exec($handler);

		  echo($response);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /store/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /store
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /store/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /store/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /store/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /store/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}