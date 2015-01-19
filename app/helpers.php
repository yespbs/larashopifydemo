<?php
/*
|--------------------------------------------------------------------------
| Application Helpers
|--------------------------------------------------------------------------
|
| Defined helpers for the Application.
|
*/

if ( ! function_exists('pr') )
{
	/**
	 * recursive dump
	 *
	 * @param mixed $var
	 * @param bool $return
	 * @return string
	 */
	function pr($var, $return=false, $html=true){	
		// pattern
		$pattern = $html ? '<pre>%s</pre>' : '%s';
		// output
		$output = sprintf( $pattern, print_r($var, true) );
		// return 
		if($return) return $output;
		// print
		echo $output;
	}
}

if ( ! function_exists('println'))
{
	/**
	 * Print with new line
	 *
	 * @param mixed
	 * @return string
	 */
	 function println(){
		// lines
		$lines = func_get_args();
		// print
    	print implode(PHP_EOL, $lines) . PHP_EOL;
    }

}

if ( ! function_exists('current_uri') )
{
	/**
	 * Current uri for the application.
	 *
	 * @param  void  
	 * @return string
	 */
	function current_uri( )
	{
		return Request::getPathInfo();		
	}
}

if ( ! function_exists('current_url') )
{
	/**
	 * Current url for the application.
	 *
	 * @param  void
	 * @return string
	 */
	function current_url( )
	{
		return app('url')->current();		
	}
}	

if ( ! function_exists('time2second') )
{
	/**
	 * get time2second
	 * 
	 * @param string $time
	 * @return string $time
	 */
	function time2second($time){
		// expire in term
		if(preg_match('/\d+ (HOUR|DAY|WEEK|MONTH|YEAR)/', $time)){
			// list
			list($unit, $period) = explode(' ',$time);
			// periods
			$periods = array('HOUR'=> 1, 'DAY'=> 24, 'WEEK'=> 168, 'MONTH'=> 720, 'YEAR'=> 8760);
			// set 
			$time = (60*60) * $unit * $periods[$period];
		}
		// return
		return $time;
	}
}

if ( ! function_exists('time2minute') )
{
	/**
	 * get time2second
	 * 
	 * @param string $time
	 * @return string $time
	 */
	function time2minute($time){
		// expire in term
		if(preg_match('/\d+ (HOUR|DAY|WEEK|MONTH|YEAR)/', $time)){
			// list
			list($unit, $period) = explode(' ',$time);
			// periods
			$periods = array('HOUR'=> 1, 'DAY'=> 24, 'WEEK'=> 168, 'MONTH'=> 720, 'YEAR'=> 8760);
			// set 
			$time = 60 * $unit * $periods[$period];
		}
		// return
		return $time;
	}
}

if ( ! function_exists('time2day') )
{
	/**
	 * time2day
	 * 
	 * @param string $time
	 * @return string $time
	 */
	function time2day($time){
		// expire in term
		if(preg_match('/\d+ (DAY|WEEK|MONTH|YEAR)/', $time)){
			// list
			list($unit, $period) = explode(' ',$time);
			// periods
			$periods = array('DAY'=> 1, 'WEEK'=> 7, 'MONTH'=> 30, 'YEAR'=> 365);
			// set 
			$time = $unit * $periods[$period];
		}
		// return
		return $time;
	}
}

if ( ! function_exists('notify_key') )
{
	/**
	 * get notify key
	 * 
	 * @param array $notify
	 * @param string $group
	 * @return void
	 */
	function notify_key( $group=null ){
		// group
		if( ! $group ){
			$key = 'errors';
		}else{
			$key = 'errors_' . lower_case( $group );
		}
		// return
		return $key;
	}
}

if ( ! function_exists('notify_set') )
{
	/**
	 * set notify
	 * 
	 * @param array $notify
	 * @param string $group
	 * @return void
	 */
	function notify_set( $notify, $group=null ){	
		// key 
		$key = notify_key( $group ) ;
		// set
		Session::flash( $key, $notify );
	}
}

if ( ! function_exists('notify_get') )
{
	/**
	 * get notify
	 * 
	 * @param string $group
	 * @return array $notify
	 */
	function notify_get( $group=null ){
		// key 
		$key = notify_key( $group ) ;

		// notify
		if ( Session::has( $key ) ) {
			$notify = Session::pull( $key );
		
			// check
			if( isset($notify['status']) )
				return $notify;			
		}
		
		// return
		return false;
	}
}

if ( ! function_exists('notify_has') )
{
	/**
	 * has notify
	 * 
	 * @param string $group
	 * @return bool
	 */
	function notify_has( $group=null ){
		// key 
		$key = notify_key( $group ) ;

		// return		
		return Session::has( $key );			
	}
}

if ( ! function_exists('notify_display') )
{
	/**
	 * display notify
	 * 
	 * @param string $group
	 * @return void
	 */
	function notify_display( $group=null ){	
		// check
		if( $notify = notify_get( $group ) ){
			// type
			$type = 'theme';//  bootstrap
			$section = is_admin_url() ? 'admin' : 'account';
			// classes
			$classes = array('success'=>'success','error'=>'danger','info'=>'info','warning'=>'warning');
			// labels
			if( 'admin' == $section ){
				$labels  = array('error'=>'Error!','success'=>'Success!','info'=>'Info!','warning'=>'Alert!');
			}else{					
				$labels  = array('error'=>'Oh snap!','success'=>'Well done!','info'=>'Heads up!','warning'=>'Warning!');
			}
			// icons	
			$icons   = array('error'=>'times-circle','success'=>'check','info'=>'info-circle','warning'=>'warning');
			// latout
			$data = array('class'=>$classes[$notify['status']], 'label'=>$labels[$notify['status']], 
				          'icon'=>$icons[$notify['status']],'message'=>$notify['message']);
			// show
			print View::make( $section . '.layouts.notify.' . $type, $data);			
		}
	}
}

if ( ! function_exists('bool_from_yn') )
{
	/**
	 * Alias Split from database select column
	 * 
	 * @param string $alias
	 * @return string $alias
	 */ 
	function bool_from_yn( $yn ){
		return starts_with($yn, 'y');
	}
}

if ( ! function_exists('alias_split') )
{
	/**
	 * Alias Split from database select column
	 * 
	 * @param string $alias
	 * @return string $alias
	 */ 
	function alias_split( $alias ){
		// CONCAT(firstname,lastname) AS name => returns name
		if(preg_match("/(\s+)AS(\s+)/i",$alias)){
			list($discard,$alias)=preg_split("/(\s+)AS(\s+)/i",$alias);
		}
		
		// A.id => return id
		if(preg_match("/[a-zA-Z]\.(.*)/",$alias)){		
			list($discard,$alias)=explode('.',$alias);		
		}
		
		// return
		return $alias;
	}
}

if ( ! function_exists('is_debug_ip') )
{
	/**
	 * is debug check by IP
	 *
	 * @param void
	 * @return bool
	 */
	function is_debug_ip(){
		// ip
		if( ! defined('DEBUG_IP') )	define('DEBUG_IP', '116.202.215.127');
		// check
		if(Request::ip() == DEBUG_IP){
			return true;
		}
		// return
		return false;
	} 	
}

if ( ! function_exists('json_decoded') )
{
	/**
	 * decode to object/array if json string
	 *
	 * @param string $original
	 * @param boolean $assoc
	 * @return mixed
	 */
	function json_decoded($original, $assoc=true){
		// return as it is if not string
		if(!is_string($original)) return $original;	
		// decoded	
		$decoded = json_decode($original, $assoc);	
		// check last error	
		return (json_last_error() == JSON_ERROR_NONE) ? $decoded : $original;
	}
}

if ( ! function_exists('is_json') )
{	
	/**
	 * is json
	 * 
	 * @param
	 * @return
	 * @deprecated
	 */
	function is_json($original){
		// check
		if(!is_string($original)) return false;	
		// decode
		json_decode($original);	
		// check last error	
		return (json_last_error() == JSON_ERROR_NONE);
	}
}

if ( ! function_exists('lower_case'))
{
	/**
	 * Convert a value to camel case.
	 *
	 * @param  string  $value
	 * @return string
	 */
	function lower_case($value)
	{
		return Str::lower($value);
	}
}

if ( ! function_exists('str_concat'))
{
	/**
	 * Concat string
	 *
	 * @param join char ( ',', ';' )
	 * @param any
	 * @return string
	 */
	function str_concat(){
		// size
		$args_size= func_num_args();
		// check min 2 words needed
		if($args_size >= 2){
			// args
			$args = func_get_args();
			// first char
			if( in_array(trim($args[0]), array(',',';')) ){
				$ic = array_shift($args);
			}else{
				$ic = ' ';
			}
			// return
			return implode($ic, array_filter($args,'str_not_empty'));
		}
		// return
		return '';
	}
}

if ( ! function_exists('str_not_empty'))
{
	/**
	 * not empty
	 * 
	 * @param
	 * @return
	 */  
	function str_not_empty($val){	
		$val = trim($val);
		return !empty($val);
	}
}

if ( ! function_exists('humanize'))
{
	
	/**
	 * Convert a value to human case.
	 *
	 * @param  string  $value
	 * @return string
	 */
	function humanize($value)
	{
		$value = str_replace(array('-', '_'), ' ', $value);

		return Str::title( $value );
	}
}

if ( ! function_exists('last_query'))
{
	/**
	 * last query 
	 *
	 * @param void
	 * @return string $last_query 
	 * @since 1.0.0
	 */
	 function last_query( $return=true ){
	 	// queries
	 	$queries = DB::getQueryLog();
		// last
		$last = end( $queries );
		// return
		return pr($last, $return);
	}
}	

if ( ! function_exists('stripslashes_deep'))
{
    /**
	 * Stripslashes
	 *
	 * @param string $str
	 * @return string
	 */
	 function stripslashes_deep($str='')
	{
		// clean till found '\'
		do{
			$str = stripslashes($str);
		}while(strpos($str, '\\') !== false);	
		// return
		return $str;
	}
}

if ( ! function_exists('create_token'))
{
    /**
	 * Create token
	 *
	 * @param int $size
	 * @return string
	 */
	function create_token( $size=6 ){
		return lower_case( Str::random( $size ) );
	}
}

if ( ! function_exists('pad_zero') )
{
    /**
	 * pad data with zero
	 *
	 * @param string $str
	 * @return string
	 */
	function pad_zero( $str ){
		return str_pad( $str, 2, '0', STR_PAD_LEFT);
	}
}	

if ( ! function_exists('get_month_options') )
{
	/**
	 * get months as key=>value pair
	 * 
	 * @param void
	 * @return array
	 */ 
	function get_month_options(){
		// init		
		$_months = array_map('pad_zero', range(1,12));					
		
		// return
		return array_combine($_months, $_months);
	}
}	

if ( ! function_exists('get_year_options') )
{	
	/**
	 * get years as key=>value pair
	 * 
	 * @param void
	 * @return array
	 */ 
	function get_year_options($before, $after){	
		// current
		$current_year = format_date('now', 'Y');

		$_years = range($current_year-$before, ($current_year + $after));		
		
		// return	
		return array_combine($_years, $_years);
	}
}	

if ( ! function_exists('add_query_args') )
{
	/**
	 * add query args
	 * 
	 * @param
	 * @return
	 */ 
	function add_query_args($args, $uri, $sep='&'){
		return $uri . (strpos($uri, '?') !== false ? '&' : '?') . http_build_query($args);
	}
}