<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */


$app_stus="PRODUCTION"; //SET TO PRODUCTION TO DISABLE ERRORS

if($app_stus=="PRODUCTION") error_reporting(0);
 
//Require all files necessary for the application to start, including user settings, soap library for enstablish the connection, and the portal classes
require_once("portal.php");

//Load the portal configuration if presents or run the wizard
PortalConfig::load();

//Establish the connection with the crm customer portal webservices
Portal::connect();

//Check if there are stored variables then if the user is previously logged or if has sent some login/forgot request, else provide him a logging screen
User::check_login();

//Start the vtlib api connection if parameters are given in the config file
Api::connect();

//Load the plugins from the plugins directory
Plugins::load_plugins();
	
//If the login is passed analyze the REQUEST and call the requested action.
Router::start();

?>
