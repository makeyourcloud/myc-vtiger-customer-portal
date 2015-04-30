<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
 

require "../portal.php";

class ConfigEditor
{

    public static function read($filename)
    {
    	if(file_exists($filename)){ 
	    	$config = include $filename;
	    	if(is_array($config)) return $config;
	        else return array();
	    }
	    else return array();
    }
    public static function write($filename, array $config)
    {
        $config = var_export($config, true);
        if(file_put_contents($filename, "<?php return $config ;")) return "OK";
        else return "<b>There was an error saving your configuration: the file '".$filename."' is not writeable!</b><br> Please give permission 644 to this file and eventually ensure that the proprietary of this file is the same that is executing this script (usually apache or www-data depending of your server).";
    }
    
    
    public static function requestPassword(){
	    $config = ConfigEditor::read('config.php');
	    if($_REQUEST['admin_email']==$config['admin_email']){
		    echo $config['admin_password'];
		    mail($config['admin_email'], "MYC Customer Portal Admin Login Details", "Your Current Administrator Details:\nUsername:".$config['admin_user']."\nPassword:".$config['admin_pass'],"From: myc-portal@no-reply.com\r\nX-Mailer: PHP/" . phpversion());
		    $mess="The Admin Password has been sent to your email address, please check your inbox, if you can't find the email please ensure that it's not present in your spam folder!";
	    }
	    else { 
	    $mess="The administration email address is not correct!";	    
	    }
	    
	    return $mess;
    }
    
       
    public static function checkLogin(){
    	
    	if(isset($_REQUEST['logout'])){ 
    		session_unset();
	    	header("Location: index.php");
    	}
    	
    	if(isset($_REQUEST['forgot'])) $reqmess=ConfigEditor::requestPassword();
    	
    	$config = ConfigEditor::read('config.php');
    	   	
	    if(!isset($_SESSION['configuration']['logged']) || !$_SESSION['configuration']['logged'] || $_SESSION['configuration']['logged']['user']!=$config['admin_user'] || $_SESSION['configuration']['logged']['password']!=$config['admin_pass']){
			//$config = ConfigEditor::read('config.php');
		    if(isset($_REQUEST['adminuser']) && isset($_REQUEST['adminpass'])){			    			    
			    if($_REQUEST['adminuser']==$config['admin_user'] && $_REQUEST['adminpass']==$config['admin_pass']){
			    	$_SESSION['configuration']['logged']=array();
			    	$_SESSION['configuration']['logged']['user']=$config['admin_user'];
			    	$_SESSION['configuration']['logged']['password']=$config['admin_pass'];
			    	return true;
			    }
			    else {
				    $_SESSION['configuration']['logged']=false;
				    $loginerror="Login Failed";
				    require("views/login.php");
				    die();
			    }
		    }
		    
		    else {
		    		    				    
			    if(!isset($config['admin_user']) || $config['admin_user'] == ""){
				    $_SESSION['configuration']['logged']=true;
			    	return true;
			    }
			    
			    else{
			    	require("views/login.php");
				    die();
				}
		    }
	    }
	    
	    else return true;
    }
    
    
}



?>