<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
 
class WSRequest {

	public static function post($wsurl,$data=array()){
		
		$dataquerystring=http_build_query($data);
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		# For use with SSL - This might be insecure!
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
		curl_setopt($ch,CURLOPT_URL, $wsurl);
		curl_setopt($ch,CURLOPT_POST, count($data));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $dataquerystring);
		$result = curl_exec($ch);
		if(curl_errno($ch))
		{
    		error_log( 'cURL-Error: ' . curl_error($ch));
		}
		curl_close($ch);
		
		
		if(!$result) return false;	
		else return json_decode($result);
		
	}
	
	public static function get($wsurl,$data=array()){
		
		if(count($data)>0) $query="?".http_build_query($data);
		else $query="";
		//$result = @file_get_contents($wsurl.$query);
		
		$ch = curl_init();	 
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		# For use with SSL - This might be insecure!
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
		curl_setopt($ch, CURLOPT_URL, $wsurl.$query);	 
		$result = curl_exec($ch);
		if(curl_errno($ch))
		{
    		error_log( 'cURL-Error: ' . curl_error($ch));
		}
		curl_close($ch);


		if(!$result) return false;	
		else return json_decode($result);
		
	}
	
	function urlExists($url=NULL)
	{
		if($url == NULL) return false;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		# For use with SSL - This might be insecure!
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
		$data = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		# For debugging errors from cURL
		if(curl_errno($ch))
		{
    		error_log( 'cURL-Error: ' . curl_error($ch));
		}
		curl_close($ch); 
		if($httpcode>=200 && $httpcode<300){
			return true;
		} else {
			return false;
		}
	}
	
}


class VTWebservices {


	var $api_user;
	var $api_pass;
	var $vtiger_ws_url;
	var $session_data;
	var $avmodules;
	
	public function __construct($vtiger_url,$api_user,$api_pass){
		
		$this->api_user=$api_user;
		$this->api_pass=$api_pass;
		$this->vtiger_ws_url=$vtiger_url."/webservice.php";
		$this->session_data=$this->login();
		
	}
	
	public function checkLogin(){
		if(!isset($this->session_data) || $this->session_data=="INVALID_CREDENTIALS" || $this->session_data=="INVALID_URL" ) return false;
		else return true;
	}
	
	public function login(){		

		$token=$this->getToken();
		if(!$token) return "INVALID_URL";
		
		$accesskey = md5($token.$this->api_pass);
        $data = array('operation' => 'login','username' => $this->api_user,'accessKey'=>$accesskey);
		
		$result=WSRequest::post($this->vtiger_ws_url,$data);
		
		if(!$result) return false;
		else {
			if(isset($result->success) && $result->success==1) return $result->result;
			else return "INVALID_CREDENTIALS";
		}		
	}

	public function getToken(){
	
		$data = array('operation' => 'getchallenge', 'username' => $this->api_user);

		$result=WSRequest::get($this->vtiger_ws_url,$data);
		
		if(!$result) return false;
		else {
			if(isset($result->success) && $result->success==1) return $result->result->token;
			else return false;
		}	
	}
	
	
	public function getModules(){
	
		$data = array('operation' => 'listtypes', 'sessionName' => $this->session_data->sessionName);
		$result=WSRequest::get($this->vtiger_ws_url,$data);		
		if(!$result) return false;
		else return json_decode(json_encode($result->result),true);
		
	} 
	
	public function getModuleId($module){
		$modules=$this->getModules();
		$x=1;		
		foreach($modules->result->types as $name){
			if($name==$module) return $x;
			$x++;
		}
		return false; 
	}
	
	
	public function getModuleFields($module){		
		$data = array('operation' => 'describe', 'sessionName' => $this->session_data->sessionName,'elementType'=>$module);
		$result=WSRequest::get($this->vtiger_ws_url,$data);		
		if(!$result) return false;
		else return json_decode(json_encode($result->result),true);		
	}
	
	public function buildConditionQuery($conditions){
		$query="";
		if(count($conditions)>0) {
			
			$query.="WHERE ";
			
			if($conditions["matchtype"]=="any") $operator="OR ";
			else $operator="AND ";
			
			foreach($conditions['conditions'] as $allc){
				$query.=$allc[0]." ".$allc[1]." '".$allc[2]."' ".$operator;
			}			
			$query=substr($query, 0, -strlen($operator));

		}
		
		return $query;
	}
	
	public function getRecordsList($module,$columns=array(),$conditions=array(),$limit=1000,$page=0){
		
		$query="SELECT ";
		
		if(count($columns)==0) $query.="* ";
		else{
			foreach($columns as $col) $query.=$col.", ";
			$query=substr($query, 0, -2)." ";
		}
				
		$query.="FROM ".$module." ";
		
		if(isset($conditions['conditions'])) $query.=$this->buildConditionQuery($conditions);	 				
		$query.=" ;";
		
		$data = array('operation' => 'query', 'sessionName' => $this->session_data->sessionName,'query'=>$query);
		$result=WSRequest::get($this->vtiger_ws_url,$data);		
		if(!$result) return false;
		else return $result->result;	
				
	}
	
	public function getRecordsCount($module,$conditions=array()){
		
		$query="SELECT COUNT(*) FROM ".$module." ";
		
		if(isset($conditions['conditions'])) $query.=$this->buildConditionQuery($conditions);	 				
		$query.=" ;";
		
		$data = array('operation' => 'query', 'sessionName' => $this->session_data->sessionName,'query'=>$query);
		$result=WSRequest::get($this->vtiger_ws_url,$data);		
		if(!$result) return false;
		else return $result->result[0]->count;	
				
	}
	
	public function getRecordDetail($recordid,$module="AUTO"){
		if($module!="AUTO") $recordid=$this->getModuleId($module)."x".$recordid;
		$data = array('operation' => 'retrieve', 'sessionName' => $this->session_data->sessionName,'id'=>$recordid);
		$result=WSRequest::get($this->vtiger_ws_url,$data);		
		if(!$result) return false;
		else return $result->result;
		
	}
	
	public function deleteRecord($recordid,$module="AUTO"){
		if($module!="AUTO") $recordid=$this->getModuleId($module)."x".$recordid;
		$data = array('operation' => 'delete', 'sessionName' => $this->session_data->sessionName,'id'=>$recordid);
		$result=WSRequest::post($this->vtiger_ws_url,$data);		
		if(!$result) return false;
		else return $result;
		
	}	
	
	public function updateRecord($recordid,$updatedinfo,$module="AUTO"){
		if($module!="AUTO") $recordid=$this->getModuleId($module)."x".$recordid;
		$recorddetails=$this->getRecordDetail($recordid);
		if(isset($recorddetails->result)) $recorddetails=json_decode(json_encode($recorddetails->result),true);
		else $recorddetails=json_decode(json_encode($recorddetails),true);

		foreach($recorddetails as $fieldname => $fieldval){
			if(isset($updatedinfo[$fieldname])) $recorddetails[$fieldname]=$updatedinfo[$fieldname];
		}
		
		if(isset($recorddetails['salesorder_no']) || isset($recorddetails['invoicestatus']) || isset($recorddetails['quotestage'])){
			$recorddetails['productid']=$recorddetails["LineItems"][0]['productid'];
		}
		
		$updatedrecord=json_encode($recorddetails);
		
		$data = array('operation' => 'update', 'sessionName' => $this->session_data->sessionName,'element'=>$updatedrecord);
		$result=WSRequest::post($this->vtiger_ws_url,$data);		
		if(!$result) return false;
		else return json_decode(json_encode($result),true);
		
	}	
	
	public function createRecord($recordinfo,$module){

		$newrecord=json_encode($recordinfo);
		
		$data = array('operation' => 'create', 'sessionName' => $this->session_data->sessionName,'element'=>$newrecord, 'elementType'=>$module);
		$result=WSRequest::post($this->vtiger_ws_url,$data);		
		if(!$result) return false;
		else return $result;
		
	}
	
	
}

 

?>