<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
 
 ?>
	   		
	   		<?php
				foreach ($loaded_plugins as $pluginname => $pluginobj){
				    	$selected=false;
							if($pluginobj->pluginconfig['is_enabled'] == "true") $selected=true; 
							?>
							
							
								   		<div class="col-md-4 text-center">
									   		<div class="panel panel-conf <?php if($selected) echo "panel-conf"; ?>">
											  <div class="panel-heading">
											    <h2 class="panel-title pull-left"><?php echo $pluginobj->plugin_label; ?></h2>
											    <?php if(!$selected): ?>											  
											  <h4 style="margin-top: 0px;" class="pull-right"><span class="label label-danger">Disabled&nbsp;</span></h4>
											  <?php else: ?>
											  <h4 style="margin-top: 0px;" class="pull-right"><span class="label label-success">Enabled&nbsp;</span></h4>
											  <?php endif; ?>
											  <br>
											  </div>
											  <div class="panel-body text-center">
											  <?php if(file_exists("../plugins/".$pluginname."/preview.png")): ?>
											    <img style="max-width:100%;" src="../plugins/<?php echo $pluginname; ?>/preview.png">
											  <?php else: ?>
											  	<img style="max-width:100%;" src="views/assets/logo_myc_bsr.png">
											  	<h4><small> No preview available</small></h4>
											  <?php endif; ?> 
											  
											  <hr>
											  <p> <?php echo $pluginobj->plugin_description; ?></p>
											  <br>
											  
											  <a class="btn btn-warning btn-lg" href="?action=plugins&pn=<?php echo $pluginname; ?>" >Plugin Settings&nbsp;<i class="fa fa-wrench"></i></a> 
											  </div>
											</div>
								   		</div>
	   		
							
							<?php
					}
						    
			?>

										<div class="col-md-4 text-center">
									   		<div class="panel panel-conf panel-conf-orange">
											  <div class="panel-heading">
											    <h3 class="panel-title">Plugin Upload</h3>
											  </div>											  
											  <div class="panel-body text-center" style="min-height:300px;">
											  <br><i onclick="$('.upload').trigger('click');" class="fa fa-plus" style="font-size:10em;color:grey;cursor:pointer;"></i><br>
											    <form enctype="multipart/form-data" method="post">
												    <div class="text-center">
													    <label>Upload New Plugin Zip or Plugin Update</label>
													 
													    <input name="plugin_zip" type="file" class="form-control" accept="application/zip" >
													    <br>
													    <input type="submit" class="btn btn-success" value="Upload and Refresh">
													</div>
												</form>
											  </div>
											</div>
								   		</div>
								   		
								
		
		   		
	   	</div>
   	</div>

 
