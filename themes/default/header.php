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
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php if(isset($GLOBALS['portal_title'])) echo $GLOBALS['portal_title']." - "; echo Language::translate(isset($module)?$module:'MYC Vtiger Customer Portal'); ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="themes/default/assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="themes/default/assets/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="themes/default/assets/css/sb-admin-2.css" rel="stylesheet">
    
    <link href="themes/default/assets/css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="themes/default/assets/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="themes/default/assets/css/chosen.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery Version 1.11.0 -->
    <script src="themes/default/assets/js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="themes/default/assets/js/bootstrap.min.js"></script>
    <script src="themes/default/assets/js/chosen.jquery.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="themes/default/assets/js/plugins/metisMenu/metisMenu.min.js"></script>
    <script src="themes/default/assets/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="themes/default/assets/js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="themes/default/assets/js/sb-admin-2.js"></script>
    
    <style>
	    #page-wrapper{ min-height: 700px !important; }
    </style>

</head>

<body>

    <div id="wrapper" >
    <?php //print_r($GLOBALS["avmod"]); ?>