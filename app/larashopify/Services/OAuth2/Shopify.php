<?php 
namespace LaraShopify\Services\OAuth2;
use League\OAuth2\Client\Provider\AbstractProvider;

class Shopify extends AbstractProvider
{
	/**
	* Store name.
	*
	* @var string
	*/
	public $store = 'larashopifydemo';
	/**
	* Autorize url.
	*
	* @return string
	*/
	public function urlAuthorize()
	{
		return sprintf('https://%s.myshopify.com/admin/oauth/authorize', $this->store);
	}
	
	/**
	* Access token url.
	*
	* @return string
	*/
	public function urlAccessToken()
	{
		return sprintf('https://%s.myshopify.com/admin/oauth/access_token', $this->store);
	}

	public function urlUserDetails(\League\OAuth2\Client\Token\AccessToken $token)
	{
		return \URL::to('oauth/user'); // @TODO: extract this somehow
	}

	public function userDetails($response, \League\OAuth2\Client\Token\AccessToken $token)
	{
		try {
			return json_decode($response);
		} catch (\Exception $ex) {
			App::make('LifecycleMail\Repositories\UserRepository')->findByStoreOAuthToken($token['access_token']);
		}
	}
} 