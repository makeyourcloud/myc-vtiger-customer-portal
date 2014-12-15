<?php 
require_once "config.class.php"; 

session_start();
define('ROOT_PATH', realpath(__DIR__.'/../'));

if(ConfigEditor::checkLogin()){
	
	if(isset($_POST['vtiger_path'])){
	
		$newconfig=$_POST;
		
		if(!isset($_POST['hiddenmodules'])) $newconfig['hiddenmodules'] = array();
		if(!isset($_POST['enabled_api_modules'])) $newconfig['enabled_api_modules'] = array();
		
		if($_FILES['portal_logo']['name']!=""){
			$ext = pathinfo($_FILES['portal_logo']['name'], PATHINFO_EXTENSION);
			$newfilename=Router::slugify(str_replace(".".$ext, "", $_FILES['portal_logo']['name'])).".".$ext;
			
			if(move_uploaded_file($_FILES['portal_logo']['tmp_name'], ROOT_PATH."/themes/default/assets/img/".$newfilename))
				$newconfig['portal_logo'] = $newfilename;	
			
			else $newconfig['portal_logo'] = "logo-myc.png";				
		}
		else $newconfig['portal_logo'] = "logo-myc.png";
		
		$altmess=ConfigEditor::write('config.php', $newconfig);		
	}
	
	$config = ConfigEditor::read('config.php');	
	$apimodules = ConfigEditor::read('apimodules.php');
	$timezones = ConfigEditor::read('timezones.php');
	
	if($_FILES['theme_zip']['name']!=""){
		$tmpfile=$config['upload_dir']."/".$_FILES['theme_zip']['name'];
		if(move_uploaded_file($_FILES['theme_zip']['tmp_name'], $tmpfile)){
				$zip = new ZipArchive;
				$res = $zip->open($tmpfile);
				if ($res === TRUE) {
				  $zip->extractTo(ROOT_PATH.'/themes/');
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
	
	echo $uploadzip;
	if($uploadzip)die();
		
	
	if(isset($_REQUEST['action']) && $_REQUEST['action']=="themes") require("views/themes.php");		
	else require("views/editor.php");	
		
	

}

	
?>
