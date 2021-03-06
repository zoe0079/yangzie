<?php
/**
 * 代理全局变量的访问，包含SESSION，GPC等等
 *
 */
class YZE_Session{
	private static $instance;
	private function __construct(){}
	/**
	 * @return YZE_Session
	 */
	public static function get_instance(){
		if (!isset(self::$instance)) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}
	/**
	 * 请注意 uri /abc/def/?a=1与/abc/def/是不一样的，用什么uri存的就得通过同样的url取
	 * uri为原始uri，也就是没有urlencode过
	 * 
	 * @param unknown_type $uri
	 * @param unknown_type $exception
	 */
	public function save_uri_exception($uri,$exception){
		$_SESSION['yze'][sha1($uri)] = $exception;
		return $this;
	}
	/**
	 *
	 * @param unknown_type $uri
	 * @return Exception
	 */
	public function get_uri_exception($uri){
		return @$_SESSION['yze'][sha1($uri)];
	}
	public function clear_uri_exception($uri){
		unset($_SESSION['yze'][sha1($uri)]);
	}
	public function has_exception($uri){
		return array_key_exists(sha1($uri), $_SESSION['yze']);
	}
	/**
	 * 在会话中保存数据，为了避免与一些系统使用会话冲突，key都hash过
	 *
	 * @param $key
	 * @return unknown_type
	 * @author liizii
	 * @since 2009-12-10
	 */
	public function get_($key){
		return @$_SESSION[sha1($key)];
	}
	public function set_($key,$value){
		$_SESSION[sha1($key)] = $value;
	}
	public function isset_($key){
		return array_key_exists(sha1($key), $_SESSION);
	}
	public function destory($key){
		unset($_SESSION[sha1($key)]);
	}

	/**
	 * 临时保存post数据
	 *
	 * @param $uri 处理post的uri
	 * @param $post filter_special_chars过滤后的数据
	 * @return void
	 * @author liizii
	 * @since 2009-12-10
	 */
	public function save_post_datas(/*string*/$uri,array $post){
		$_SESSION['yze']['post_cache'][sha1($uri)] = $post;
	}
	/**
	 * 取得缓存的post数据
	 *
	 * @param  $uri 处理post的uri
	 * @return array filter_special_chars过滤后的数据
	 * @author liizii
	 * @since 2009-12-10
	 */
	public function get_post_datas(/*string*/$uri){
		return @$_SESSION['yze']['post_cache'][sha1($uri)];
	}
	/**
	 *
	 * @param $uri 处理post的uri
	 * @return void
	 * @author liizii
	 * @since 2009-12-10
	 */
	public function clear_post_datas(/*string*/$uri){
		unset($_SESSION['yze']['post_cache'][sha1($uri)]);
	}

	public function save_uri_datas(/*string*/$uri,array $datas){
		$_SESSION['yze']['uri_cache'][sha1($uri)] = $datas;
	}

	public function get_uri_datas(/*string*/$uri){
		return @$_SESSION['yze']['uri_cache'][sha1($uri)];
	}

	public function clear_uri_datas(/*string*/$uri){
		unset($_SESSION['yze']['uri_cache'][sha1($uri)]);
	}
	public function set_request_token($uri, $token){
		$_SESSION['yze']["token"][$uri] = $token;
	}
	public function get_request_token($uri){
		return @$_SESSION['yze']["token"][$uri];
	}
	public function clear_request_token(){
		unset($_SESSION['yze']["token"]);
	}
	public function clear_request_token_ext($uri){
		unset($_SESSION['yze']["token"][$uri]);
	}
	public static function get_cached_post($name,$uri=null)
	{
		if (empty($uri)) {
			$uri = YZE_Request::get_instance()->the_uri();
		}
		$dates = YZE_Session::get_instance()->get_post_datas($uri);
		return @$dates[$name];
	}

	public static function post_cache_has($name,$uri=null)
	{
		if (empty($uri)) {
			$uri = YZE_Request::get_instance()->the_uri();
		}
		return array_key_exists($name,(array)@$_SESSION['yze']['post_cache'][sha1($uri)]);
	}

	public static function post_cache_has_ext($uri=null)
	{
		if (empty($uri)) {
			$uri = YZE_Request::get_instance()->the_uri();
		}
		return @$_SESSION['yze']['post_cache'][sha1($uri)];
	}
	
}

?>