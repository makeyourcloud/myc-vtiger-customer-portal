<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
?>
<?php require_once("themes/default/header.php"); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default"  id="loginpanel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo Language::translate("Please Sign In"); ?></h3>
                    </div>
                    <div class="panel-body">
                    
                    <div class="text-center">
	                    <img src="themes/default/assets/img/<?php echo $GLOBALS['portal_logo']?>" style="padding:20px;max-width:100%;">
                    </div>
                    
                    <?php if(isset($loginerror)):  ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					  <?php echo Language::translate($loginerror); ?>
					</div>
                    <?php endif;  ?>
                    <?php if(isset($successmess)):  ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
					  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					  <?php echo Language::translate($successmess); ?>
					</div>
                    <?php endif;  ?>
                        <form role="form" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="<?php echo Language::translate("E-mail"); ?>" name="email" type="email" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="<?php echo Language::translate("Password"); ?>" name="pass" type="password" value="" required>
                                </div>
                                <div class="form-group">
                                    <select class="form-control" name="lang" required>
                                    	<?php foreach($GLOBALS['languages'] as $file => $lang) {
                                    			echo '<option value="'.$file.'"';
                                                if($file==$GLOBALS['default_language']) echo ' selected';
                                                echo '>'.$lang.'</option>';
                                            }
	                                    ?>
                                    </select>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block"><?php echo Language::translate("Login"); ?></button>
                                <a onclick="$('#loginpanel').hide();$('#forgotpanel').show();" class="btn btn-lg btn-warning btn-block"><?php echo Language::translate("Forgot Password"); ?></a>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <div class="login-panel panel panel-default" id="forgotpanel">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo Language::translate("Request Password"); ?></h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="post" >
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="<?php echo Language::translate("E-mail"); ?>" name="email" type="email" autofocus required>
                                    <input name="forgot" type="hidden" value="1" >
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block"><?php echo Language::translate("Send Request"); ?></button>
                                <a onclick="$('#forgotpanel').hide();$('#loginpanel').show();" class="btn btn-lg btn-warning btn-block"><?php echo Language::translate("Go to Login"); ?></a>

                            </fieldset>
                            <!-- <img src='http://makeyourcloud.com/pstats.php?t=default'> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script> $(function(){ $('#forgotpanel').hide(); }) </script>
  
<?php require_once("themes/default/footer.php"); ?>