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
            <link href="views/assets/editor.css" rel="stylesheet">
    <link href="../themes/default/assets/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../themes/default/assets/css/chosen.min.css" rel="stylesheet" type="text/css">

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
  <body class="login">
   
   	
  
    <div class="container">
        <div class="row">
<div style="  text-align: center;">
						<img  src="views/assets/logo_myc_bsr.png">
                    </div>
            <div class="col-md-4 col-md-offset-4" >
                <div class="login-panel panel panel-default"  id="loginpanel">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Portal Configuration Login</h3>
                    </div>
                    <div class="panel-body">
                    
                    <?php if(isset($loginerror)):  ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					  <?php echo ($loginerror); ?>
					</div>
                    <?php endif;  ?>
                    <?php if(isset($reqmess)):  ?>
                    <div class="alert alert-warning alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					  <?php echo ($reqmess); ?>
					</div>
                    <?php endif;  ?>                    
                    <?php if(isset($_GET['pe'])): ?>
		   			<div class="alert alert-danger" role="alert">The vTiger Path you specified seems to be not working, please ensure that you provided the correct vTiger installation path and that customer portal is enabled and configured in your crm!
		   			</div>
		   			<?php endif; ?>
	   			
                        <form role="form" method="post">
                            <fieldset>
                            <p class="help-block">Enter your admin credentials to access the portal configuration!</p>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="adminuser" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="adminpass" type="password" required>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->

                                <button type="submit" class="btn btn-lg btn-conf btn-block">Login</button>
                                <a onclick="$('#loginpanel').hide();$('#forgotpanel').show();" class="btn btn-lg btn-warning btn-block">Forgot Password</a>

                            </fieldset>
                        </form>
                    </div>
<div class="panel-footer">
<p>© Copyright 2015 <a target="_blank" href="http://www.makeyourcloud.com">Proseguo SL </a></p>
</div>
                </div>
				<div class="login-panel panel panel-default" id="forgotpanel">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Request Administration Password</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" >
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Administrator E-mail" name="admin_email" type="email" autofocus required>
                                    <input name="forgot" type="hidden" value="1" >
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-conf btn-block">Send Request</button>
                                <a onclick="$('#forgotpanel').hide();$('#loginpanel').show();" class="btn btn-lg btn-warning btn-block">Go to Login</a>

                            </fieldset>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<script> $(function(){ $('#forgotpanel').hide(); }) </script>
  </body>

</html>
