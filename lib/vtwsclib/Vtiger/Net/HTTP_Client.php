<?php

require_once('lib/vtwsclib/third-party/curl_http_client.php');
require_once('lib/vtwsclib/third-party/Zend/Json.php');

class Vtiger_HTTP_Client extends Curl_HTTP_Client {
	var $_serviceurl = '';

	function __construct($url) {
		if(!function_exists('curl_exec')) {
			die('Vtiger_HTTP_Client: Curl extension not enabled!');
		}
		parent::__construct();
		$this->_serviceurl = $url;
		$useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
		$this->set_user_agent($useragent);

		// Escape SSL certificate hostname verification
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);	
	}

	function doPost($postdata=false, $decodeResponseJSON=false, $timeout=20) {
		if($postdata === false) $postdata = Array();
		$resdata = $this->send_post_data($this->_serviceurl, $postdata, null, $timeout);
		if($resdata && $decodeResponseJSON) $resdata = $this->__jsondecode($resdata);
		return $resdata;
	}

	function doGet($getdata=false, $decodeResponseJSON=false, $timeout=20) {
		if($getdata === false) $getdata = Array();
		$queryString = '';
		foreach($getdata as $key=>$value) {
			$queryString .= '&' . urlencode($key)."=".urlencode($value);
		}
		$resdata = $this->fetch_url("$this->_serviceurl?$queryString", null, $timeout);
		if($resdata && $decodeResponseJSON) $resdata = $this->__jsondecode($resdata);
		return $resdata;
	}

	function __jsondecode($indata) {
		return Zend_Json::decode($indata);
	}

	function __jsonencode($indata) {
		return Zend_Json::encode($indata);
	}
}

?>
