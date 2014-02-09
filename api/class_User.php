<?php

!defined('P_W') && exit('Forbidden');
//api mode 1

define('API_USER_USERNAME_NOT_UNIQUE', 100);

class User {
        var $cookie_key = 'Leq_668_Hk8_auth';
	var $base;
	var $db;

	function User($base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function synlogin($user) {
		global $timestamp,$uc_key;
		list($windid, $winduid, $windpwd) = explode("\t", $this->base->strcode($user, false));
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		$safecv = '';
		$cktime = 31536000;
	        $cktime += $timestamp;
                $value = $this->base->strcode($winduid."\t".md5($windid.$timestamp), true);
		setcookie($this->cookie_key,$value,$cktime);

		return '';
	}

	function synlogout() {
		header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
		setcookie($this->cookie_key,' ',0);
		return '';
	}
}
?>
