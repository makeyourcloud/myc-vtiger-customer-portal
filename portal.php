<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */

require_once('lib/nusoap/lib/nusoap.php');
require_once('lib/mycwsapi/webservices.class.php');

class Router
{

 	/*****************************************************************************
 	* Function: Router::start()
 	* Description: This function intercept the $_REQUEST parameters and call the requested action 
	* ****************************************************************************/

	public static function start() 
    {
    
    	global $avmod;
    									
		
		$targetmodule=$_REQUEST['module'];
		$targetaction=$_REQUEST['action'];
		
		//Get a list of available module for this user 
		$params = array($_SESSION["loggeduser"]['id']);
		
		$avmod=$GLOBALS["sclient"]->call('get_modules',$params);
		
		//If the dashboard is enabled show them as the index module of the portal
		if($GLOBALS["show_dashboard"]=="true"){
			$avmod=array_merge(array("Home"),$avmod);
		}
		
		//If the vtlib api are configured add the configured module to the enabled modules array
		if(isset($GLOBALS['api_user']) && $GLOBALS['api_user']!="" && isset($GLOBALS['api_pass']) && $GLOBALS['api_pass']!=""){
			if(Api::connect()!='API_LOGIN_FAILED')
				if(isset($GLOBALS['api_modules']) && count($GLOBALS['api_modules'])>0)			
					foreach($GLOBALS['api_modules'] as $modname => $modfields)
						if(isset($modfields["is_enabled"]) && $modfields["is_enabled"]=="true") $avmod[]=$modname;
						//if(in_array($modname, $GLOBALS['enabled_api_modules'])) $avmod[]=$modname;	
						 
		}
		
		Plugins::runall("PortalBase","base","preTemplateLoad",$_REQUEST);
		
		//if no target module specified set the first module defined in the CRM portal settings as the default index module
		if(!isset($targetmodule) || $targetmodule=="") $targetmodule=$avmod[0];
		
		//if a download for a file is requested call the function to retrieve the desired file
		if(isset($_REQUEST['downloadfile']) && $_REQUEST['downloadfile']==="true") User::download_file();
		
		//Check if the requested module is Available
		if(!in_array($targetmodule, $avmod)){ 
			Template::display($targetmodule,array(),'not-authorized'); 
			die();
		}
		
		
		//Require the base module class
		require_once("modules/Module/index.php");
		
		//if isset a specific file and a specific class for the requested module include the extended class and create the object
		if(file_exists("modules/".$targetmodule."/index.php")) require_once("modules/".$targetmodule."/index.php");
		if(class_exists($targetmodule)) $mod=new $targetmodule();
		else $mod=new BaseModule($targetmodule);
		
		//if is pesent a target id show the corrispondent entity else show a list of entities for the target module	
		if(isset($_REQUEST['ticketid'])) $mod->detail($_REQUEST['ticketid']);
		else if(isset($_REQUEST['productid'])) $mod->detail($_REQUEST['productid']);
		else if(isset($_REQUEST['faqid'])) $mod->detail($_REQUEST['faqid']);
		else if(isset($_REQUEST['id'])) $mod->detail($_REQUEST['id']);
			

		
		else if($targetmodule=="HelpDesk" && $targetaction=="new") $mod->create_new();

		else if($targetmodule=="Home" || $targetaction=="dashboard") $mod->dashboard();

		else $mod->get_list();
		
		//if there is a request for change password call the modal again and show the request resault
		if(isset($GLOBALS["opresult"]) && $GLOBALS["opresult"]!="") echo "<script> $(function(){ $('#changePassModal').modal('show'); })</script>";

    
    }
    
    
    
    public static function slugify($text)
	{ 
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);	
	  // trim
	  $text = trim($text, '-');	
	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);	
	  // lowercase
	  $text = strtolower($text);	
	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);	
	  if (empty($text))
	  {
	    return 'n-a';
	  }	
	  return $text;
	}
    

}
  


class Template 
{

	/*****************************************************************************
 	* Function: Template::display()
 	* Description: This function receive 3 parameters the module wich you want to display, the data array to pass to the view
 	* and the view name (the name of the view file). 
	* ****************************************************************************/
	
    public static function display($module,$data,$viewname) 
    {
    	
      //If a parameter theme is specified in the REQUEST, the theme will be setted as requestes, else the default theme will be loaded
      if(isset($_REQUEST['theme']) && $_REQUEST['theme']!="" && is_dir("themes/".$_REQUEST['theme']))
      $_SESSION["portal_theme"]=$_REQUEST['theme'];
      
      if(isset($_SESSION["portal_theme"])) $currtheme=$_SESSION['portal_theme'];
      
      else {
      	if(isset($GLOBALS["portal_theme"]))
      		$currtheme=$GLOBALS["portal_theme"];
      	else $currtheme="default";
      }
      
      $data=Plugins::runall($module,$viewname,"preTemplateLoad",$data);
      if(!isset($data['plugin_data'])) $data['plugin_data']=array();
      //Require common header and menu files	
   	  require_once("themes/".$currtheme."/header.php");
	  require_once("themes/".$currtheme."/menu.php");
    
	  //Fallback cascade theme inclusion, first check if is present a specified view for the current module in the current theme folder
      if(file_exists("themes/".$currtheme."/modules/".$module."/".$viewname.".php")) 
		require_once("themes/".$currtheme."/modules/".$module."/".$viewname.".php");
	
	  //else check if is present a specified DEFAULT view for the current module in the current module folder
	  else if(file_exists("modules/".$module."/layouts/".$viewname.".php")) 
		require_once("modules/".$module."/layouts/".$viewname.".php");
	  
	  //else check if is present a specified DEFAULT view for COMMON modules in the current theme module folder 	
	  else if(file_exists("themes/".$currtheme."/modules/Module/".$viewname.".php")) 
		require_once("themes/".$currtheme."/modules/Module/".$viewname.".php");
	
	  //else require the DEFAULT view for COMMON modules in the comon module folder
	  else require_once("modules/Module/layouts/".$viewname.".php");
	  
	  //Require common footer file
	  require_once("themes/".$currtheme."/footer.php");
	  
	  Plugins::runall($module,$viewname,"postTemplateLoad",$data);
	  
    }

    public static function displayPlugin($pluginname,$data,$viewname) 
    {
    	if(file_exists("plugins/".$pluginname."/views/".$viewname.".php")) 
			require_once("plugins/".$pluginname."/views/".$viewname.".php");
    }    
    
    
}

class Language
{

	/*****************************************************************************
 	* Function: Language::translate()
 	* Description: This function return the translated string, if it is found in the language file, else it will return the term as
 	* prompted
	* ****************************************************************************/
	
	public static function translate($term,$lang=false) 
    {

		if($lang) $sel_lang=$lang;
		else if(isset($_SESSION["loggeduser"]['language'])) $sel_lang=$_SESSION["loggeduser"]['language'];
		else $sel_lang=key($GLOBALS['languages']);
		
		if(file_exists(ROOT_PATH."/languages/".$sel_lang.".lang.php")) include(ROOT_PATH."/languages/".$sel_lang.".lang.php");
		
		if(preg_match('/\\A(?:^((\\d{2}(([02468][048])|([13579][26]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])))))|(\\d{2}(([02468][1235679])|([13579][01345789]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|(1[0-9])|(2[0-8]))))))(\\s(((0?[0-9])|(1[0-9])|(2[0-3]))\\:([0-5][0-9])((\\s)|(\\:([0-5][0-9])))?))?$)\\z/', $term) || $term=="2015-03-26 19:31:51"){
			$date=strtotime($term);
			if(strlen($term)>10) return date($GLOBALS['date_format'].' h:i', $date);
			else return date($GLOBALS['date_format'], $date);
			
		}
		

		
    	if(isset($app_strings[$term])) return $app_strings[$term];
    	else return $term;
    
    }
    

}




class PortalConfig
{

    
    public static function load()
    {    
	    define('ROOT_PATH', realpath(__DIR__));
	    
    	if(file_exists(ROOT_PATH."/configuration/config.php")){
	        $config = require ROOT_PATH."/configuration/config.php";
			$config['api_modules'] =  require ROOT_PATH."/configuration/apimodules.php";
			
			if(is_array($config)){
				
				foreach($config as $param => $val){
					global $$param;
					$GLOBALS[$param]=$val;
				}
				
				if(isset($GLOBALS['default_timezone']) && $GLOBALS['default_timezone']!="") 
					date_default_timezone_set($GLOBALS['default_timezone']);
											
				foreach (scandir(ROOT_PATH."/languages/") as $key => $value){
					if (!in_array($value,array(".","..")) && strpos($value, '.lang.php') !== false){
						$value=str_replace(".lang.php", "", $value); 						
						$GLOBALS['languages'][$value]=Language::translate($value,$value);							
					}						
				}
					
				$def_lang = $GLOBALS['languages'][$GLOBALS['default_language']];
				unset($GLOBALS['languages'][$GLOBALS['default_language']]);
				
				$GLOBALS['languages']=array_merge(array($GLOBALS['default_language']=>$def_lang),$GLOBALS['languages']);		
							
			}	
			
			else {
				header("Location: configuration/index.php");
				die();
			}	
		}
		
		else {
			header("Location: configuration/index.php");
			die();	    
		} 
	}   
	
    
}

class Portal{

	public static function connect(){
		global $sclient;
		session_start();
		$sclient = new soapclient2($GLOBALS['vtiger_path']."/vtigerservice.php?service=customerportal");
		$sclient->soap_defencoding = $GLOBALS['default_charset'];
		
		if(WSRequest::urlExists($GLOBALS['vtiger_path']."/vtigerservice.php?service=customerportal")===false){
			header("Location: configuration/index.php?pe=errpath");
			die();
		}
	}
	

}


class Api{
	
	/*****************************************************************************
 	* Function: Api::connect()
 	* Description: This function try (if api user and pass are provided in the config file) 
 	* to set the connection with the vtiger webservices api
 	* api using vtlib library
	* ****************************************************************************/
	
	public static function connect() 
    {
    	global $api_client;
    	
		if(isset($GLOBALS['api_user']) && $GLOBALS['api_user']!="" && isset($GLOBALS['api_pass']) && $GLOBALS['api_pass']!=""){
			require_once('lib/vtwsclib/Vtiger/WSClient.php');
					
			$client = new Vtiger_WSClient($GLOBALS['vtiger_path']);
			
			$login = $client->doLogin($GLOBALS['api_user'], $GLOBALS['api_pass']);
			if(!$login) $api_client='API_LOGIN_FAILED';
			else {
				$api_client = $client;
				MYCWSApi::connect();
			} 
		}
		
		else $api_client="NOT_CONFIGURED";
		
		return $api_client;
    
    }
    
    
    public static function getModuleId($module){
	    $modules = $GLOBALS['api_client']->doListTypes();
	    $c=1;
	    foreach($modules as $modulename => $moduleinfo) {
	       if($modulename==$module) return $c;
	       $c++;
		} 
    }
    
    public static function is_connected(){
    	global $api_client;
	    if(!isset($api_client) || $api_client=="NOT_CONFIGURED" ||  $api_client=="API_LOGIN_FAILED") { 
	    	Api::connect();
	    	if(!isset($api_client) || $api_client=="NOT_CONFIGURED" ||  $api_client=="API_LOGIN_FAILED")
	    		return false;
	    	else return true;	
	    }
	    else return true;
    }
	
	
}

class MYCWSApi{
	public static function connect() 
    {
    	global $mycwsapi;
    	
		if(isset($GLOBALS['api_user']) && $GLOBALS['api_user']!="" && isset($GLOBALS['api_pass']) && $GLOBALS['api_pass']!=""){			
					
			$mycwsapi=new VTWebservices($GLOBALS['vtiger_path'],$GLOBALS['api_user'], $GLOBALS['api_pass']);
			if(!$mycwsapi->checkLogin()) $mycwsapi='API_LOGIN_FAILED';
		}
		
		else $mycwsapi="NOT_CONFIGURED";
		
		return $api_client;
    
    }	
}  
  
  
class User
{

		
		/*****************************************************************************
	 	* Function: User::check_login()
		* ****************************************************************************/
		
		public static function check_login() 
	    {
	    	global $opresult;
	    
			//ADDED TO ENABLE THEME SWITCHING
			if(isset($_REQUEST['theme']) && $_REQUEST['theme']!="" && is_dir("themes/".$_REQUEST['theme']))
			   $_SESSION["portal_theme"]=$_REQUEST['theme'];
			      
			if(isset($_SESSION["portal_theme"])) $currtheme=$_SESSION['portal_theme'];
			      
			else $currtheme=$GLOBALS["portal_theme"];
			//********************************
			        
			
			if(isset($_REQUEST['logout'])) {
				session_unset();
				$_SESSION["portal_theme"]=$currtheme;
				header("Location: index.php");
				die();
			}
		
			if(!isset($_SESSION['loggeduser']) || $_SESSION["loggeduser"]=="ERROR") {
				
				$login=false;
				
				if(isset($_REQUEST["email"]) && isset($_REQUEST["pass"])) $login=User::portal_login($_REQUEST["email"],$_REQUEST["pass"]);
				
				if(isset($_REQUEST["email"]) && isset($_REQUEST["forgot"])) $lres=User::forgot_password($_REQUEST["email"]);

				if(!$login || $login[0]=="INVALID_USERNAME_OR_PASSWORD") {
					
					if($login[0]=="INVALID_USERNAME_OR_PASSWORD") $loginerror= $login[0];
					
					if(isset($lres) && $lres=="ERROR") $loginerror="The Email you Request is not in our system!";
					
					else if(isset($lres) && $lres=="SUCCESS") $successmess="We have send an Email containing your Password at the requested Address!";
					
																									
					
					if(file_exists("themes/".$currtheme."/login.php")) require_once("themes/".$currtheme."/login.php");
					else require_once("themes/default/login.php"); 
					
					session_unset();
					die();
					
				}
			
			}
			
			else User::portal_login($_SESSION['loggeduser']['user_name'],$_SESSION['loggeduser']['user_password']);
			
			if(isset($_SESSION['loggeduser']) && isset($_REQUEST['fun']) && $_REQUEST['fun']=="changepassword")
			$GLOBALS["opresult"]=User::change_password();
		}








		/*****************************************************************************
	 	* Function: User::forgot_password()
		* ****************************************************************************/

		function forgot_password($email){
		
			$params = array('email' => $email);
			$result = $GLOBALS["sclient"]->call('send_mail_for_password', $params);
		
			if(strpos($result,'false')!==false) return "ERROR";
			else return "SUCCESS";
			
		}


		/*****************************************************************************
	 	* Function: User::portal_login()
		* ****************************************************************************/
	
		function portal_login($email,$password){
		
			if(isset($_REQUEST['lang']) && file_exists("language/".$_REQUEST['lang'].".lang.php")) $tlang = $_REQUEST['lang'];
				
			else if(isset($_SESSION["loggeduser"]['language'])) $tlang=$_SESSION["loggeduser"]['language'];
				
			else $tlang = $GLOBALS['default_language'];
		
			$params = array('user_name' => "$email",
			'user_password'=>"$password",
			'version' => "6.0.1");
		
			$result = $GLOBALS["sclient"]->call('authenticate_user', $params);
			
			if(isset($result[0]['id'])){ 								
				
				$_SESSION["loggeduser"] = $result[0];
				$_SESSION["loggeduser"]['language'] = $tlang;
				
				$params = Array('id'=>$_SESSION["loggeduser"]['id']);
				$_SESSION["loggeduser"]["accountid"] = $GLOBALS["sclient"]->call('get_check_account_id', $params);
				
			}
			
			return $result;
		}
		
		
		/*****************************************************************************
	 	* Function: User::change_password()
	 	* Parameters: $_REQUEST Array
	 	* Description: This function is derived from the original change_password function 
	 	* written in the Vtiger Customer Portal by the Vtiger Team
		* ****************************************************************************/
			
		//Added for My Settings - Save Password
		function change_password($version="6.0.0")
		{
			global $client;
			
			$customer_id = $_SESSION["loggeduser"]['id'];
			$customer_name = $_SESSION["loggeduser"]['user_name'];
			$oldpw = trim($_REQUEST['old_password']);
			$newpw = trim($_REQUEST['new_password']);
			$confirmpw = trim($_REQUEST['confirm_password']);
		
			$params = array('user_name'=>"$customer_name",'user_password'=>"$oldpw",'version'=>"$version",'login'=>'false');
			$result = $GLOBALS["sclient"]->call('authenticate_user',$params);
			$sessionid = $_SESSION["loggeduser"]['sessionid'];
			if(isset($result) && isset($result[0]['user_password']) && $oldpw == $result[0]['user_password'])
			{
				if(strcasecmp($newpw,$confirmpw) == 0)
				{
					$customerid = $result[0]['id'];
								
					$sessionid = $_SESSION["loggeduser"]['sessionid'];
		
					$params = array(array('id'=>"$customerid", 'sessionid'=>"$sessionid", 'username'=>"$customer_name",'password'=>"$newpw",'version'=>"$version"));
		
					$result_change_password = $GLOBALS["sclient"]->call('change_password',$params);
					if($result_change_password[0] == 'MORE_THAN_ONE_USER'){
						$errormsg .= 'MORE_THAN_ONE_USER';
					}else{
						$errormsg .= 'MSG_PASSWORD_CHANGED';
					}
				}
				else
				{
					$errormsg .= 'MSG_ENTER_NEW_PASSWORDS_SAME';
				}
			}elseif($result[0] == 'INVALID_USERNAME_OR_PASSWORD') {
				$errormsg .= 'LBL_ENTER_VALID_USER';	
			}elseif($result[0] == 'MORE_THAN_ONE_USER'){
				$errormsg .= 'MORE_THAN_ONE_USER';
			}
			else
			{
				$errormsg .= 'MSG_YOUR_PASSWORD_WRONG';
			}
		
			return $errormsg;
		}


		/*****************************************************************************
	 	* Function: User::download_file()
	 	* Parameters: $_REQUEST Array
	 	* Description: This function is derived from the original download function 
	 	* written in the Vtiger Customer Portal by the Vtiger Team
		* ****************************************************************************/

		function download_file(){
	
					$filename = $_REQUEST['filename'];
					$fileType = $_REQUEST['filetype'];
					//$fileid = $_REQUEST['fileid'];
					$filesize = $_REQUEST['filesize'];
		
					//Added for enhancement from Rosa Weber
		
					
					if($_REQUEST['module'] == 'Documents')
					{
						$id=$_REQUEST['id'];
						$folderid = $_REQUEST['folderid'];
						$block = $_REQUEST['module'];
						$params = array('id' => "$id", 'folderid'=> "$folderid",'block'=>"$block", 'contactid'=>$_SESSION["loggeduser"]['id'],'sessionid'=>$_SESSION["loggeduser"]['sessionid']);
						$result = $GLOBALS["sclient"]->call('get_filecontent_detail', $params);
						$fileType=$result[0]['filetype'];
						$filesize=$result[0]['filesize'];
						$filename=html_entity_decode($result[0]['filename']);
						$fileContent=$result[0]['filecontents'];
					}
					else if(isset($_REQUEST['ticketid']))
					{
						$ticketid = $_REQUEST['ticketid'];
						$fileid = $_REQUEST['fileid'];
						//we have to get the content by passing the customerid, fileid and filename
						$customerid = $_SESSION["loggeduser"]['id'];
						$sessionid = $_SESSION["loggeduser"]['sessionid'];
						$params = array(array('id'=>$customerid,'fileid'=>$fileid,'filename'=>$filename,'sessionid'=>$sessionid,'ticketid'=>$ticketid));
						$fileContent = $GLOBALS["sclient"]->call('get_filecontent', $params);
						
						/* PROBLEMI NEL CRM DOCUMENTI A DOPPIO NASCOSTI
						$params = array('id' => $fileid,'sessionid'=>$sessionid);
						$r=$GLOBALS["sclient"]->call('updateCount', $params);
						print_r($r);
						die();
						*/
						$fileContent = $fileContent[0];
						$filesize = strlen(base64_decode($fileContent));
		
					}
					
					else {
						if(isset($GLOBALS['api_modules'][$_REQUEST['module']])) $block=substr($_REQUEST['module'], 0, -2);
						else $block = $_REQUEST['module'];
						$id=$_REQUEST['id'];
						
												
						$params = array('id' => "$id", 'block'=>"$block", 'contactid'=>$_SESSION["loggeduser"]['id'],'sessionid'=>$_SESSION["loggeduser"]['sessionid'], 'language'=>$_SESSION["loggeduser"]['language']);
						$fileContent = $GLOBALS["sclient"]->call('get_pdfmaker_pdf', $params);
						//if something went wrong within the get_pdf_maker function then call the standard function get_pdf   
						
						
						if($fileContent[0] != "failure"  && isset($fileContent[0]))
						{
						    $fileType ='application/pdf';
						    $filename = $fileContent[0];
						    $fileContent = $fileContent[1];
						    $filesize = strlen(base64_decode($fileContent));
						}
						else
						{
						    $params = array('id' => "$id", 'block'=>"$block", 'contactid'=>$_SESSION["loggeduser"]['id'],'sessionid'=>$_SESSION["loggeduser"]['sessionid']);
						    $fileContent = $GLOBALS["sclient"]->call('get_pdf', $params);
						    $fileType ='application/pdf';
						    $fileContent = $fileContent[0];
						    $filesize = strlen(base64_decode($fileContent));
						    $filename = "$block.pdf";
						}
						
						if($fileContent=="#NOT AUTHORIZED#") header("Location: index.php?module=".$_REQUEST['module']."&action=index");

		
					}
					
					// : End
		
					//we have to get the content by passing the customerid, fileid and filename
					$customerid = $_SESSION["loggeduser"]['id'];
					$sessionid = $_SESSION["loggeduser"]['sessionid'];
		
					header("Content-type: $fileType");
					header("Content-length: $filesize");
					header("Cache-Control: private");
					header("Content-Disposition: attachment; filename=$filename");
					header("Content-Description: PHP Generated Data");
					echo base64_decode($fileContent);
					exit;		
			
		}


}  

class Plugins {
	
	public static function load_plugins(){
		global $loaded_plugins;		
		foreach (scandir(ROOT_PATH."/plugins/") as $key => $pluginname){
			if (!in_array($pluginname,array(".",".."))) 
				if(file_exists(ROOT_PATH."/plugins/".$pluginname."/".$pluginname.".php")){
					include_once(ROOT_PATH."/plugins/".$pluginname."/".$pluginname.".php");
					$pluginclassname = ucfirst($pluginname)."Plugin";		
					$loaded_plugins[$pluginname] = new $pluginclassname;
				}		
		}
	}
	
	public static function runall($modulename,$action,$event,$data=array()){
		global $loaded_plugins;
		foreach($loaded_plugins as $pluginname => $pluginInstance){
			if(in_array($modulename,$pluginInstance->affectedmodules) || in_array("Portal", $pluginInstance->affectedmodules))
				if(method_exists($pluginInstance,$event))
					$data=$pluginInstance->$event($modulename,$action,$data);
			
		}
		return $data;
		
	}
 	
}




?>