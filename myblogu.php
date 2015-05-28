<?php
/*
	Plugin Name: MyBlogU
	Plugin URI: http://myblogu.com
	Description:  <strong>MyBlogU official plugin</strong>
	Version: 0.0.8
	Author:  Michael Tikhonin (MyBlogU)
	Author URI: http://phpclimber.com
	License: GPL2

    Copyright 2015  MyBlogU  (info@myblogu.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


define( 'MBU_VERSION', '0.0.8' );
//define( 'MBU_TEST_ENV', 1);         // comment this line on production

define('MBU_DISPLAY_NAME', 'MyBlogU');
define( 'MBU_REQUIRED_WP_VERSION', '3.2' );

if ( ! defined( 'MBU_PLUGIN_BASENAME' ) )
	define( 'MBU_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

if ( ! defined( 'MBU_PLUGIN_NAME' ) )
	define( 'MBU_PLUGIN_NAME', trim( dirname( MBU_PLUGIN_BASENAME ), '/' ) );

if ( ! defined( 'MBU_SLUG' ) )
	define( 'MBU_SLUG', basename(dirname(__FILE__)));

if ( ! defined( 'MBU_PLUGIN_DIR' ) )
	define( 'MBU_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . MBU_PLUGIN_NAME );

if ( ! defined( 'MBU_PLUGIN_URL' ) )
	define( 'MBU_PLUGIN_URL', WP_PLUGIN_URL . '/' . MBU_PLUGIN_NAME );

if ( ! defined( 'MBU_PLUGIN_INCLUDES_DIR' ) )
	define( 'MBU_PLUGIN_INCLUDES_DIR', MBU_PLUGIN_DIR . '/includes' );

if (! defined('MBU_BLOG_URL')){
    $blog_url = trim(get_bloginfo('url', 'raw'), '/\\ ');
        define('MBU_BLOG_URL', $blog_url);
}

if ( ! defined( 'MBU_API_BASE_URL' ) )
{
    if(defined('MBU_TEST_ENV')) {
		// flush plugin updates to ensure we get the latest.
	//	set_site_transient('update_plugins', null);
		
		// display some debug data about plugin updates
		//add_filter('plugins_api_result', 'aaa_result', 10, 3);
	

         define('MBU_BASE_URL', 'http://mbg.home/app' );
     }
     else
     {
         define( 'MBU_BASE_URL', 'http://myblogu.com' );
     }

    define('MBU_API_BASE_URL', MBU_BASE_URL.'/api' );
}

define('MBU_URL', 'http://myblogu.com');


if ( ! defined( 'MBU_LOAD_JS' ) )
	define( 'MBU_LOAD_JS', true );

if ( ! defined( 'MBU_JS_URL' ) )
	define( 'MBU_JS_URL', MBU_PLUGIN_URL . '/js/mbu_process.js' );
	
if ( ! defined( 'MBU_LOAD_CSS' ) )
	define( 'MBU_LOAD_CSS', true );

if ( ! defined( 'MBU_CSS_URL' ) )
	define( 'MBU_CSS_URL', MBU_PLUGIN_URL . '/css/mbu.css' );

if ( ! defined( 'MBU_IMG_URL' ) )
	define( 'MBU_IMG_URL', MBU_PLUGIN_URL . '/img' );

if ( ! defined( 'MBU_SHOW_DEBUG' ) )
	define( 'MBU_SHOW_DEBUG', false );

if ( ! defined( 'MBU_APP_AUTH_URL' ) )
	define( 'MBU_APP_AUTH_URL', MBU_API_BASE_URL.'/authorize?client_id=%APP_ID%&response_type=code&state=articles' );

if ( ! defined( 'MBU_USER_LOGIN_URL' ) )
	define( 'MBU_USER_LOGIN_URL', MBU_API_BASE_URL.'/authorize' );

if ( ! defined( 'MBU_REDIRECT_URI' ) )
	define( 'MBU_REDIRECT_URI', MBU_PLUGIN_URL . '/token.php' );

if ( ! defined( 'MBU_IMGS' ) )
	define( 'MBU_IMGS', MBU_PLUGIN_URL . '/img' );

if ( ! defined( 'MBU_AJAX' ) )
	define( 'MBU_AJAX', get_admin_url() . 'admin-ajax.php' );

if ( ! defined( 'MBU_CACHE_LIVETIME' ) )        // период обновления локального кеша данных
	define( 'MBU_CACHE_LIVETIME', 3600);

//update_option("mbu_version_message", '');

// Take over the update checker in Wordpress
//add_filter('pre_set_site_transient_update_plugins', 'check_for_plugin_update');
				
/* Loading Includes */

add_action( 'plugins_loaded', 'mbu_load_includes', 1 );

function mbu_load_includes() {
    $dir = MBU_PLUGIN_INCLUDES_DIR;

    if ( ! ( is_dir( $dir ) && $dh = opendir( $dir ) ) )
	return false;

    while ( ( $includes = readdir( $dh ) ) !== false ) {
	if ( substr( $includes, -4 ) == '.php' ) {
            include_once $dir . '/' . $includes;
		mbu_debug("Loaded Module: $includes");
            }			
    }
}

	
/* Show Debug Messages */
function mbu_debug($debug_message)
{
	if (MBU_SHOW_DEBUG) {
	echo ( "DEBUG: $debug_message\n<br>"); 
	}
}

register_activation_hook( __FILE__, 'mbu_activate' );
register_deactivation_hook( __FILE__, 'mbu_remove' );

        /*
         * начальная инициализация плагина из файла
         */
function mbu_activate()
{
$fname = MBU_PLUGIN_DIR.'/init_options.php';

	if(file_exists($fname))
	{
	include_once $fname;
	@unlink($fname);
	}
	
	if(isset($init_options))
	{
	add_option('mbu_options', $init_options, '', 'yes');
	update_option('mbu_options', $init_options);
	}
//die(json_encode(array()));
}


	// mb_string 
	
if(!function_exists('mb_strtolower'))
{
    function mb_strtolower($str)
    {
	return strtolower($str);
    }
}

    // полономочие, необходимое для использования плагина
if(!defined('MBU_REQUIRED_CAPABILITY'))
{
    define('MBU_REQUIRED_CAPABILITY', 'publish_posts');
}

	// find post by title
	
	// find post by title



function mbu_download_file($url, $local_path)
{
    set_time_limit(0); // unlimited max execution time

    $options = array(
        CURLOPT_FILE    => fopen($local_path, 'w+'),
        CURLOPT_TIMEOUT => 28800, // set this to 8 hours so we dont timeout on big files
        CURLOPT_URL     => $url,
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);

    //curl_setopt($ch, CURLOPT_CLOSEPOLICY, CURLCLOSEPOLICY_LEAST_RECENTLY_USED);
    //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    curl_exec($ch);

    $responseInfo = curl_getinfo($ch);
    curl_close($ch);

    return $responseInfo['http_code'];
}

function mbu_process_http($url, &$http_code = null, $postdata = false){


    $user_agents = array(
	'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.30 Safari/525.13',
	'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)',
	'Mozilla/4.0 (compatible; MSIE 8.0; AOL 9.5; AOLBuild 4337.43; Windows NT 6.0; Trident/4.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.5.21022; .NET CLR 3.5.30729; .NET CLR 3.0.30618)',
	'Mozilla/5.0 (X11; U; Linux i686; pl-PL; rv:1.9.0.2) Gecko/20121223 Ubuntu/9.25 (jaunty) Firefox/3.8',
	'Mozilla/5.0 (Windows; U; Windows NT 5.2; zh-CN; rv:1.9.2) Gecko/20100101 Firefox/3.6',
	'Mozilla/4.0 (compatible; MSIE 7.0b; Windows NT 5.1; .NET CLR 1.1.4322)',
	'Mozilla/5.0 (Windows; U; Windows NT 6.1; ko-KR) AppleWebKit/531.21.8 (KHTML, like Gecko) Version/4.0.4 Safari/531.21.10',
    );


    $curl_conn = curl_init();

    shuffle($user_agents);

    curl_setopt($curl_conn, CURLOPT_URL, $url); //URL to connect to

    if($postdata)
    {
	curl_setopt($curl_conn, CURLOPT_POST, true);
      	curl_setopt($curl_conn, CURLOPT_POSTFIELDS, $postdata);
      	curl_setopt($curl_conn, CURLOPT_CUSTOMREQUEST, 'POST');
    }

    curl_setopt($curl_conn, CURLOPT_CONNECTTIMEOUT, 20);
    //curl_setopt($curl_conn, CURLOPT_LOW_SPEED_LIMIT, 1024);
    //curl_setopt($curl_conn, CURLOPT_LOW_SPEED_TIME, 5);
    //curl_setopt($curl_conn, CURLOPT_CLOSEPOLICY, CURLCLOSEPOLICY_LEAST_RECENTLY_USED);
    curl_setopt($curl_conn, CURLOPT_RETURNTRANSFER, 1);

    curl_setopt($curl_conn, CURLOPT_FOLLOWLOCATION, 1);

    $user_agent = $user_agents[0];
    curl_setopt($curl_conn, CURLOPT_USERAGENT, $user_agent);

    curl_setopt($curl_conn, CURLOPT_SSL_VERIFYPEER, false); 	//Do not check SSL certificate (but use SSL of course), live dangerously!

	// Result from querying URL. Will parse as xml
    $output = curl_exec($curl_conn);
			
	// close cURL resource. It's like shutting down the water when you're brushing your teeth.
    //var_dump($output);			
    $responseInfo = curl_getinfo($curl_conn);
    curl_close($curl_conn);

    $http_code = $responseInfo['http_code'];

    if($responseInfo['http_code'] != 200)
	return false;

    if($output && trim($output) != '')
	return $output;
    else
	return false;
}

		/*
		Выполняет запрос к MyBlogU API
		*/
function mbu_api($url, $data = null, $silent = false, $method = 'POST')
{
    $ret = '';

    $options = get_option('mbu_options');
    $token = (!empty($options) && isset($options['oauth_token'])) ? $options['oauth_token'] :'';

    if($data == null)
    {
        $data = array();
    }

    $body = array_merge($data, array("oauth_token" => $token, "addition_info" => array('plugin_version' => MBU_VERSION)));

    $http_code = 0;

    $postdata = '';

    foreach($body as $key => $val)
    {
        if(!is_array($val))
        {
            $postdata .= $key.'='.urlencode($val).'&';
        }
    }
    
    if($method == 'GET')
    {
        $url .= '?'.$postdata;
        $postdata = null;
    }
    $result = mbu_process_http($url, $http_code, $postdata);
    if ($http_code != 200) {
                //var_dump($result->errors);
		// display error message of some sort
	$error =  "There was a  problem contacting the server ($http_code)";
    } else {
	$arr = json_decode($result, true);
		
	if(empty($arr))
	{
            $error = 'Bad response format!';
	}
	if(!empty($arr['error']))
	{
            $error = $arr['error']['msg'];
	}
	else
	{
            $ret = $arr;
            if(!empty($arr['msg']) && !$silent)
            {
		mbuShowMessage($arr['msg']);
            }
	}
    }

    return ((!empty($error)) ? $error : $ret);
}

function mbuIsInitialized()
{
    $token = mbuGetOption('oauth_token');
    return !empty($token);
}

function mbuGetOption($option_name, $def = ''){

    $options = get_option('mbu_options');
    $val = (!empty($options) && isset($options[$option_name])) ? $options[$option_name] : $def;

    return $val;
}

function mbuRunTpl($tpl, $params = null)
{

	
    $tpl_path = MBU_PLUGIN_DIR.'/tpl/'.$tpl.'.php';
	
    if(!empty($params))
    {
        foreach($params as $var => $val)
	{
            $$var = $val;
	}
    }
    
    ob_start();
    include $tpl_path;
    $ret = ob_get_clean();

    if(strpos($ret, chr(239).chr(187).chr(191)) === 0)
    {
        $ret = substr($ret, 3);
    }

    return trim($ret, ' ');
}


if(!function_exists('mbu_array_to_obj'))
{
    function mbu_array_to_obj($array, &$obj = null)
    {
        if(!is_object($obj))
        {
            $obj = (object) array();
        }
	
        foreach ($array as $key => $value)
        {
            if (is_array($value))
            {
                $obj->$key = new stdClass();
		array_to_obj($value, $obj->$key);
            }
            else
            {
                $obj->$key = $value;
            }
        }
        return $obj;
    }
}

    /*
     *  загружает информацию о пользователе и сохраняет ее в mbu_user_info
     */
function mbuUpdateUserInfo()
{
    if(mbuIsInitialized())
    {
        $ret = mbu_api(MBU_API_BASE_URL.'/oauth', array('action' => 'get_curr_user'));
        if(!is_string($ret))
        {
            $user_info = $ret['userinfo'];
            $user_info['timestamp'] = time();
            add_option('mbu_user_info', $user_info, '', 'yes');
            update_option('mbu_user_info', $user_info);

            $mbu_options = get_option('mbu_options');
            if(is_array($mbu_options) && isset($user_info['site']['id_category']))
            {
                $mbu_options['id_category'] = $user_info['site']['id_category'];
                $mbu_options['tags'] = $user_info['site']['tags'];
                update_option('mbu_options', $mbu_options);
            }        
            
            return $user_info;
        }
    }
    return null;
}

    /*
     *  возвращает данные о текущем пользователе MBU
     */
function mbuGetUserInfo()
{
    $user_info = get_option('mbu_user_info');
    if(empty($user_info) || empty($user_info['timestamp']) || ($user_info['timestamp'] + MBU_CACHE_LIVETIME) < time())
    {
        $user_info = mbuUpdateUserInfo();
    }
    return $user_info;
}

    /*
     *  загружает информацию о непрочитанных уведомлениях и сохраняет ее в mbu_messages
     */
function mbuUpdateMessages()
{
    if(mbuIsInitialized())
    {
        $ret = mbu_api(MBU_API_BASE_URL.'/pm', array('action' => 'get_incoming', 'statuses' => 'sent,delivered', 'autocreated' => 1));
        if(!is_string($ret))
        {
            unset($ret['status']);
            unset($ret['success']);
            $ret['timestamp'] = time();
            add_option('mbu_messages', $ret, '', 'yes');
            update_option('mbu_messages', $ret);
            
            return $ret;
        }
    }
    return null;
}

    /*
     *  возвращает данные о непрочитанных уведомлениях MBU
     */
function mbuGetMessages()
{
    $data = get_option('mbu_messages');
    if(empty($data) || empty($data['timestamp']) || ($data['timestamp'] + MBU_CACHE_LIVETIME) < time())
    {
        $data = mbuUpdateMessages();
    }
    return $data;
}


    /*
     *  загружает информацию о категориях
     */
function mbuUpdateCategories()
{
    $ret = mbu_api(MBU_API_BASE_URL.'/site', array('action' => 'get_categories'), true);

    if(!is_string($ret))
    {
        $ret['timestamp'] = time();
        add_option('mbu_categories', $ret, '', 'yes');
        update_option('mbu_categories', $ret);
            
        return $ret;
    }
    return null;
}


function mbuGetCategories()
{
    $data = get_option('mbu_categories');
    if(empty($data) || empty($data['timestamp']) || ($data['timestamp'] + 10*MBU_CACHE_LIVETIME) < time())
    {
        $data = mbuUpdateCategories();
    }

    return (isset($data['categories']) ? $data['categories'] : null);
}

	// find post by interview
function mbuGetPostByInterview($id_interview, $output = OBJECT) {
    global $wpdb;
	
    $post = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s AND meta_key='mbu_interview_id'", $id_interview ));

    if($post)
    {
        return get_post($post, $output);
    }

    return null;
}

function mbuGetBlogTitle()
{
    $blog_title = get_bloginfo('name', 'display');
    if(empty($blog_title))
    {
        $blog_title = mbuGetDomainFromURL(MBU_BLOG_URL);
    }
    return $blog_title;
}

function mbuGetDomainFromURL($url){
    $host = parse_url($url, PHP_URL_HOST);
    if($host){
        $host = strtolower(mbuTrimWWW(trim($host)));
    }
    return $host;
}

function mbuTrimWWW($host){
    if(strpos($host, "www.") === 0){
        $host = substr($host, 4);
    }
    return $host;
}
