<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
 
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MYC Portal - Configuration Editor</title>

    <!-- Bootstrap -->
    <link href="../themes/default/assets/css/bootstrap.min.css" rel="stylesheet">


<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <link href="../themes/default/assets/css/chosen.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/editor.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery Version 1.11.0 -->
    <script src="../themes/default/assets/js/jquery-1.11.0.js"></script>


    <!-- Bootstrap Core JavaScript -->
    <script src="../themes/default/assets/js/bootstrap.min.js"></script>
    <script src="../themes/default/assets/js/chosen.jquery.min.js"></script>
    
  </head>
  <body>



    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header" style="width:50%;" >
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" style="padding: 7px 7px;" href="#"><img style="max-width:100%;" src="views/assets/logo_myc_bss.png" alt="MYC Portal Configuration"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li ><a target="_blank" href="http://www.makeyourcloud.com/store/themes-for-vtiger-customer-portal"><i class="fa fa-shopping-cart"></i> MYC Store</a></li>
            <li ><a target="_blank" href="http://www.makeyourcloud.com/support/faq.html"><i class="fa fa-question-circle"></i> F.A.Q.</a></li>
            <li ><a target="_blank" href="http://www.makeyourcloud.com/support/tutorials-myc-vtiger-customer-portal.html"><i class="fa fa-book"></i> Tutorials</a></li>
            <li ><a target="_blank" href="http://forum.makeyourcloud.com"><i class="fa fa-users"></i> Forum</a></li>
            <li  style="background-color:red;"><a href="index.php?logout=1"><i class="fa fa-sign-out"></i> Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          	<li role="presentation" class="label label-conf" style="text-align: left; padding: 10px 12px; border-radius: 0!important;"><i class="fa fa-gear fa-lg"></i>  General Settings</li>
            <li <?php if(!isset($_REQUEST['action'])) echo 'class="active"'; ?>><a href="index.php">Portal Configuration</a></li>
            
          </ul>
		  
          <ul class="nav nav-sidebar">
          	<li role="presentation" class="label label-conf" style="text-align: left; padding: 10px 12px;border-radius: 0!important;"><i class="fa fa-paint-brush fa-lg"></i>  Themes & Appearance</li>
            <li <?php if($_REQUEST['action']=="themes") echo 'class="active"'; ?>><a href="index.php?action=themes">Themes Manager</a></li>
            <li <?php if($_REQUEST['action']=="themestore") echo 'class="active"'; ?>><a href="index.php?action=themestore">Themes Store</a></li>
            <li <?php if($_REQUEST['action']=="appearance") echo 'class="active"'; ?>><a href="index.php?action=appearance">Appearance Settings</a></li>            
          </ul>
          <ul class="nav nav-sidebar">
            <li role="presentation" class="label label-conf" style="text-align: left; padding: 10px 12px;border-radius: 0!important;"><i class="fa fa-puzzle-piece fa-lg"></i>  Plugins Configurations</li>
            <li <?php if($_REQUEST['action']=="plugins" && $_REQUEST['pn']!="modulebuilder") echo 'class="active"'; ?>><a href="index.php?action=plugins">Plugins Manager</a></li>
            <li <?php if($_REQUEST['action']=="pluginstore") echo 'class="active"'; ?>><a href="index.php?action=pluginstore">Plugins Store</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="col-sm-12">

	   			
	   			<h3><?php echo $pagetitle; ?></h3>  
	   			 			
	   			<?php if(isset($pluginsettings['altmess'])) $altmess=$pluginsettings['altmess']; if(isset($altmess) && $altmess=="OK"): ?><div class="alert alert-success" role="alert">Your configuration has been saved correctly! </div>
	   			
	   			<?php elseif(count($config)==0): ?>
	   			<div class="alert alert-danger" role="alert"><b>Your configuration is not correct or you don't have yet configured this installation, You should set the parameters below to complete the MYC Customer Portal setup!</b><br> Is important to set an administrator username and password to restrict the access to this page, if an admin username is set, the next time will be shown a login page and you must insert the administration credentials to continue.
		   			You can access this configuration page when you need at the address http://yourportaladdress.com/configuration
	   			</div>
	   			<?php elseif (isset($altmess) && $altmess!="OK"): ?><div class="alert alert-danger" role="alert"><?php echo $altmess; ?></div>
	   			<?php elseif(isset($_GET['pe'])): ?>
	   			<div class="alert alert-danger" role="alert">The vTiger Path you specified seems to be not working, please ensure that you provided the correct vTiger installation path and that customer portal is enabled and configured in your crm!
	   			</div>
	   			<?php endif; ?>
	   			
	   			<?php if(isset($customalert)): ?>
	   			<div class="alert alert-<?php echo $customalert['type']; ?>" role="alert"><?php echo $customalert['message']; ?></div>
	   			<?php if(isset($customalert['dieonerror']) && $customalert['dieonerror']==true) die(); endif; ?>
	   			
	   			<hr>
	   		</div>
