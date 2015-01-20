<?php 
namespace LaraShopifyDemo\Services\OAuth2;
use League\OAuth2\Client\Provider\AbstractProvider;

class Shopify extends AbstractProvider
{
	/**
	* Store name.
	*
	* @var string
	*/
	public $store = '';
	/**
	* Autorize url.
	*
	* @return string
	*/
	public function urlAuthorize()
	{
		$urlAuthorize = sprintf('https://%s.myshopify.com/admin/oauth/authorize', $this->store);

		\Log::debug('urlAuthorize: '. $urlAuthorize, array('context'=>'urlAuthorize'));

		return $urlAuthorize;
	}
	
	/**
	* Access token url.
	*
	* @return string
	*/
	public function urlAccessToken()
	{
		$urlAccessToken = sprintf('https://%s.myshopify.com/admin/oauth/access_token', $this->store);
		
		\Log::debug('urlAccessToken: '. $urlAccessToken, array('context'=>'urlAccessToken'));

		return $urlAccessToken;
	}

	/**
	 * @todo
	 * user url not available with Shopify, will can later user api resource
	 * @see http://docs.shopify.com/api/user
	 */ 
	public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
	{
		return \URL::to('stores/user-details'); // @TODO: extract this somehow
	}

	/**
	 * @todo
	 */ 
	public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
	{
		try {
			return json_decode($response);
		} catch (\Exception $e) {
			//App::make('LifecycleMail\Repositories\UserRepository')->findByStoreOAuthToken($token['access_token']);
			\Log::error( $e->getMessage(), array('context'=>'Shopify_userDetails') );
		}

		return false;
	}

	public function setStore( $store ){
		$this->store = str_replace('.myshopify.com', '', $store);
	}
} 