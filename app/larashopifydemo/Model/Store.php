<?php
namespace LaraShopifyDemo\Model;

/**
 * Store 
 * 
 * @package LaraShopify
 * @subpackage Laravel
 */
class Store extends \Eloquent {
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'stores';

	/**
	 * Timestamp
	 * 
	 * @var bool
	 */ 
	public $timestamps = true;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Fillable
	 * 
	 * @var array
	 */ 
	protected $fillable = ['store','access_token'];

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}
}