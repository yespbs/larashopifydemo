<?php
use GuzzleHttp\Client;

class StoreController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /store
	 *
	 * @return Response
	 */
	public function anyIndex()
	{
		$data = array();

		$data['stores'] = \LaraShopifyDemo\Model\Store::all();

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
		
		$post = Input::get();

		// log
		Log::debug( pr( $post, true ) );

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

			    // Use this to interact with an API on the users behalf
			    \Log::debug( 'accessToken: '. $token->accessToken);
			   
			    try{

	            	// get or empty object, does not use fillable
		            $store = \LaraShopifyDemo\Model\Store::firstOrCreate(array('store'=>$shop, 'access_token'=>$token->accessToken));

		            // save
		            $store->save();

		    		// set
					$errors = array('status'=>'success','message'=>'You have connected with Shopify successfully.');

		            return Redirect::to('stores')->with('errors', $errors);
		            
		        }catch ( Exception $e ){
		        	println($e->getMessage());
		        }    
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

	/*public function anyRevoke()
	{
		$access_token = '843ddbcd3442da597df883088c9c151e';//Config::get("shopify.secret_key");
	    $revoke_url   = "https://larashopifydemo.myshopify.com/admin/oauth/revoke";

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

	public function anyTest()
	{
		$access_token = '4d70c544a97c6f09011edeb45495e2e6';//Config::get("shopify.secret_key");
		
		$client = new Client();
		
		$endpoint_url = "https://larashopifydemo.myshopify.com/admin/webhooks.json";

		$post = ['webhook'=>['topic'=>'orders/create','address'=>'http://sologicsolutions.com/shopify/track/orders.create','format'=>'json']];

		$response = $client->post($endpoint_url, [
			'json' => $post,
			'headers' => ['X-Shopify-Access-Token' => $access_token]
		]);

		$json = $response->json();

		pr($json);

		$endpoint_url = "https://larashopifydemo.myshopify.com/admin/webhooks.json";

		$response = $client->get($endpoint_url, [			
			'headers' => ['X-Shopify-Access-Token' => $access_token]
		]);

		$json = $response->json();

		pr($json);
	}*/

	/**
	 * Show the form for creating a new resource.
	 * GET /store/create
	 *
	 * @return Response
	 */	
	public function anyWebhooks( $id )
	{
		//echo 'store:' .$id;

		$data = array();

		try{
			$data['store'] = $store = \LaraShopifyDemo\Model\Store::findOrFail($id);

			$client = new Client();

			$endpoint_url = "https://larashopifydemo.myshopify.com/admin/webhooks.json";

			$response = $client->get($endpoint_url, [			
				'headers' => ['X-Shopify-Access-Token' => $store->access_token]
			]);

			$json = $response->json();

			//pr($json);die;

			$data['webhooks'] = $json['webhooks'];

			//pr($data);
			//die;
			$data['format_options'] = ['json'=>'JSON','xml'=>'XML'];
		}catch (Exception $e){
			\Log::error($e->getMessage());

			// set
			$errors = array('status'=>'error','message'=>'No such store.');

            return Redirect::to('stores')->with('errors', $errors);
		}

		return View::make('stores.webhooks', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /store/create
	 *
	 * @return Response
	 */	
	public function postWebhookCreate()
	{
		// create new product
		if ( Input::has('act') && 'create_webhook' == Input::get('act')) {
			// post
			$post = Input::get();

			$store_id = $post['store_id'];

			// init
			$errors	= array('status'=>'error', 'message'=>"Couldn't create webhook!");

			try{
				$store = \LaraShopifyDemo\Model\Store::findOrFail($store_id);
				
				$client = new Client();
		
				$endpoint_url = "https://".$store->store."/admin/webhooks.json";

				$post = ['webhook'=>['topic'=>$post['topic'],'address'=>$post['address'],'format'=>$post['format']]];

				$response = $client->post($endpoint_url, [
					'json' => $post,
					'headers' => ['X-Shopify-Access-Token' => $store->access_token]
				]);

				$json = $response->json();

				\Log::debug( pr($json, true) );

				// init
				$errors	= array('status'=>'success', 'message'=>"Webhook created successfully!");

				// redirect with flash				
				return Redirect::to( sprintf('stores/%d/webhooks', $store->id) )->with( 'errors', $errors );	
			}catch( Excepriotn $e ){
				$errors['message'] .= ' ' . $e->getMessage();
			}	

			// redirect with flash				
			return Redirect::to( 'stores' )->with( 'errors', $errors );	
		}	
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