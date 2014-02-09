<?php
defined('P_W') || define('P_W', '1');

require_once BASEPATH.'../uc_config.php';

if ( ! function_exists('strcode'))
{
 function strcode($string, $encode = true, $apikey = '') {
    $uc_key = getKeyBydomain();
    $apikey = $apikey ? $apikey: $uc_key;
    !$encode && $string = base64_decode($string);
    $code = '';
    $key  = substr(md5($_SERVER['HTTP_USER_AGENT'] . $apikey),8,18);
    $keylen = strlen($key);
    $strlen = strlen($string);
    for ($i = 0; $i < $strlen; $i++) {
      $k    = $i % $keylen;
      $code  .= $string[$i] ^ $key[$k];
    }
    return ($encode ? base64_encode($code) : $code);
  } 
}

if ( ! function_exists('getcode'))
{
  function getcode($len = 6){
    $str = 'qwertyuioplkjhgfdsazxcvbnm1234567890,.?;:!@#$%^&*()-=+';
    $length = strlen($str) - 1;
    $tmp = '';
    for($i=0;$i<$len;$i++){
      $tmp .= $str[mt_rand(0,$length)];
    }
    return $tmp;
  }
}

if ( ! function_exists('get_client_ip'))
{
  function get_client_ip(){
    $ip = $_SERVER['REMOTE_ADDR'];
    return $ip;
  }
}

if ( ! function_exists('getKeyBydomain'))
{
  function getKeyBydomain(){
    global $domain_app;
    $domain = strtolower($_SERVER['HTTP_HOST']);
    return $domain_app[$domain];
  }
}

if ( ! function_exists('getSynuserUid'))
{
  function getSynuserUid(){
    global $cookie_key;
    $apikey = getKeyBydomain();
    if(isset($_COOKIE[$cookie_key])){
      $code = $_COOKIE[$cookie_key];
      $uinfo = strcode($code, false, $apikey);
      list($uid) = explode("\t", $uinfo);
      return $uid;
    }
    return false;
  }
}

if ( ! function_exists('getSynuserInfo'))
{
  function getSynuserInfo($uid){
    global $uc_api,$master_uckey;
    $request = array(
    'params'=>"$uid",
    'type'=>'uc',
    'mode'=>'User',
    'method'=>'getInfo'
    );
    $url = $uc_api.strtrip($request,$master_uckey);
    $ctx = stream_context_create(array(
    'http' => array(
        'timeout' => 15
        )
    )
    );
    $uinfo = file_get_contents($url, null, $ctx);
    $uinfo = unserialize($uinfo);
    $uinfo = $uinfo['result'][$uid];
    $groups = explode(',', $uinfo['groups']);
    $groups[] = $uinfo['groupid'];
    $groups = array_unique($groups);
    $uinfo['groups'] = $groups;
    return $uinfo;
  }
}

if ( ! function_exists('strtrip'))
{
  function strtrip($request,$uckey){
    ksort($request);
    reset($request);
    $arg = '';
    foreach ($request as $key => $value) {
      if ($value) {
        $value = stripslashes($value);
        $arg .= "$key=$value&";
      }
    }
    $sig = md5($arg.$uckey);
    $return = $arg."sig=$sig";

    return $return;
  }
}

?>
