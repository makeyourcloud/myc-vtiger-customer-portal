<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
?>

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"><?php echo Language::translate("Toggle navigation"); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="padding: 5px 15px;">
	                <img src="themes/default/assets/img/<?php echo $GLOBALS['portal_logo']?>" style="max-height:40px;">
                </a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li><a href="index.php?logout=1"><i class="fa fa-sign-out fa-fw"></i> <?php echo Language::translate("Logout"); ?></a></li>
                 <li><a href="" data-toggle="modal" data-target="#changePassModal"> <?php echo Language::translate("Change Password"); ?></a><li>
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu"> 
                    <?php foreach($GLOBALS["avmod"] as $mod){
						if(!in_array($mod, $GLOBALS['hiddenmodules']))
	                    echo '<li>
                            <a href="index.php?module='.$mod.'&action=index">'.Language::translate($mod).'</a>
                        </li>';
                    } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>