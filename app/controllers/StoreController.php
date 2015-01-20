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

		/*$provider = new LaraShopifyDemo\Services\OAuth2\Shopify(array(
		    'clientId'  =>  '1e02bf129dce9915d49d9443b54ad43f',
		    'clientSecret'  =>  'fa4400b7ef1743b8c270bd2a4557f024',
		    'redirectUri'   =>  'http://localhost/laravel-shopify/develop/public/stores/connect',//https://your-registered-redirect-uri/
		    'scopes' => array('email', '...', '...'),
		));

		if (!isset($_GET['code'])) {

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

		} else {

		    // Try to get an access token (using the authorization code grant)
		    $token = $provider->getAccessToken('authorization_code', [
		        'code' => $_GET['code']
		    ]);

		    // If you are using Eventbrite you will need to add the grant_type parameter (see below)
		    $token = $provider->getAccessToken('authorization_code', [
		        'code' => $_GET['code'],
		        'grant_type' => 'authorization_code'
		    ]);

		    // Optional: Now you have a token you can look up a users profile data
		    try {

		        // We got an access token, let's now get the user's details
		        $userDetails = $provider->getUserDetails($token);

		        // Use these details to create a new profile
		        printf('Hello %s!', $userDetails->firstName);

		    } catch (Exception $e) {

		        // Failed to get user details
		        exit('Oh dear...');
		    }

		    // Use this to interact with an API on the users behalf
		    echo $token->accessToken;

		    // Use this to get a new access token if the old one expires
		    echo $token->refreshToken;

		    // Number of seconds until the access token will expire, and need refreshing
		    echo $token->expires;
		}*/
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