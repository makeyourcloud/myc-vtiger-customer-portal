<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
 
require_once "config.class.php"; 

session_start();
define('ROOT_PATH', realpath(__DIR__.'/../'));

if(ConfigEditor::checkLogin()){
	
	

	$config = ConfigEditor::read('config.php');	
	if(isset($config) && is_array($config) && count($config)>0){
		PortalConfig::load();
		MYCWSApi::connect();
	}
	$apimodules = ConfigEditor::read('apimodules.php');
	$timezones = ConfigEditor::read('timezones.php');
	
	if(isset($_POST['updateconfig'])){
		unset($_POST['updateconfig']);
		$newconfig=$_POST;
		
		if(!isset($_POST['hiddenmodules']) && !isset($config['hiddenmodules'])) $newconfig['hiddenmodules'] = array();
		if(!isset($_POST['enabled_api_modules']) && !isset($config['enabled_api_modules'])) $newconfig['enabled_api_modules'] = array();
		
		if($_FILES['portal_logo']['name']!="" || !isset($config['portal_logo']) || $config['portal_logo']==""){
			$ext = pathinfo($_FILES['portal_logo']['name'], PATHINFO_EXTENSION);
			$newfilename=Router::slugify(str_replace(".".$ext, "", $_FILES['portal_logo']['name'])).".".$ext;
			
			if(move_uploaded_file($_FILES['portal_logo']['tmp_name'], ROOT_PATH."/themes/default/assets/img/".$newfilename))
				$newconfig['portal_logo'] = $newfilename;	
			
			else $newconfig['portal_logo'] = "logo-myc.png";				
		}
		else $newconfig['portal_logo'] = "logo-myc.png";
		$newconfig = array_merge($config, $newconfig);
		$altmess=ConfigEditor::write('config.php', $newconfig);		
	}
	
	$config = ConfigEditor::read('config.php');

	
	if($_FILES['theme_zip']['name']!=""){
		$tmpfile=$config['upload_dir']."/".$_FILES['theme_zip']['name'];
		if(move_uploaded_file($_FILES['theme_zip']['tmp_name'], $tmpfile)){
				$zip = new ZipArchive;
				$res = $zip->open($tmpfile);
				if ($res === TRUE) {
				  $zip->extractTo(ROOT_PATH.'/');
				  $zip->close();
				  $uploadzip="OK";
				} 
				else $uploadzip="ERR";
		}
		else $uploadzip="ERR";
	}
	
	if($_FILES['plugin_zip']['name']!=""){
		$tmpfile=$config['upload_dir']."/".$_FILES['plugin_zip']['name'];
		if(move_uploaded_file($_FILES['plugin_zip']['tmp_name'], $tmpfile)){
				$zip = new ZipArchive;
				$res = $zip->open($tmpfile);
				if ($res === TRUE) {
				  $zip->extractTo(ROOT_PATH.'/');
				  $zip->close();
				  $uploadzip="OK";
				} 
				else $uploadzip="ERR";
		}
		else $uploadzip="ERR";
	}
	
	if(isset($_GET['deftheme']) && is_dir(ROOT_PATH.'/themes/'.$_GET['deftheme'])){
		$config['portal_theme']=$_GET['deftheme'];
		$altmess=ConfigEditor::write('config.php', $config);
	}
	
		
	
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="themes"){ 
		$pagetitle="Themes Manager";
		$viewname="themes";
	}	
	else if(isset($_REQUEST['action']) && $_REQUEST['action']=="themestore"){ 
		$pagetitle="Themes Store";
		$viewname="themestore";
	}
	else if(isset($_REQUEST['action']) && $_REQUEST['action']=="pluginstore"){ 
		$pagetitle="Plugins Store";
		$viewname="pluginstore";
	}
	else if(isset($_REQUEST['action']) && $_REQUEST['action']=="appearance"){
		$pagetitle="Appearance Settings";
		$viewname="appearance";
	}
	
	else if(isset($_REQUEST['action']) && $_REQUEST['action']=="plugins"){
		Plugins::load_plugins();
		if(!isset($_REQUEST['pn'])){
			$pagetitle="Plugins Manager";			
			$viewname="plugins";
		}
		else{
			$pluginname=$_REQUEST['pn'];
			if(isset($loaded_plugins[$pluginname])){
				$pluginsettings=$loaded_plugins[$pluginname]->settings();
				if(!$pluginsettings){
					$customalert['type']='danger';
					$customalert['dieonerror']=true;
					$customalert['message']='This plugin <b>require the vTiger WS Api connection</b>, please ensure to put correct credentials (vTiger WS Api Username and Api Key) in the <a href="index.php">Portal Configuration</a> Page.';
				}
				$pagetitle=$loaded_plugins[$pluginname]->plugin_label." Settings";						
			}
			else{
				$customalert['type']='danger';
				$customalert['dieonerror']=false;
				$customalert['message']='The plugin you are searching for is currently not installed on this MYC Customer Portal instance!';
				$pagetitle="Plugins Manager";			
				$viewname="plugins";
				unset($pluginname);
			}
		}
	}
	
		
	else{ 
		$pagetitle="General Settings";
		$viewname="editor";	
	}
	
	require("views/header.php");
	if(!isset($pluginname)) require("views/".$viewname.".php");	
	else {
		if(file_exists(ROOT_PATH.'/plugins/'.$pluginname."/views/settings.php"))
			require ROOT_PATH.'/plugins/'.$pluginname."/views/settings.php";
	}
	require("views/footer.php");	

}

	
?>
