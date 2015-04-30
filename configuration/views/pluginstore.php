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
									$plugins = @simplexml_load_file("http://makeyourcloud.com/store/plugins-xml.php");
									if(isset($plugins[0])): 		
														
								    foreach($plugins as $plugin):
									?>
									
									<div class="col-md-4 text-center">
									   		<div class="panel panel-conf">
											  <div class="panel-heading">
											    <h3 class="panel-title"><?php echo $plugin->Name; ?></h3>
											  </div>
											  <div class="panel-body text-center">
											    <img style="max-width:100%;" src="<?php echo $plugin->PreviewImg; ?>">
											  <hr>
											  <p>
												  <?php echo $plugin->ShortDesc; ?>
											  </p>
											  
											  <?php if(floatval($plugin->SalePrice)!=floatval($plugin->Price)): ?>
											  <h4><s style="color:red;">Old Price: <?php echo $plugin->Price; ?> €</s></h4>
											  <h3>Promo Price: <?php echo $plugin->SalePrice; ?> €<?php if(floatval($plugin->SalePrice==0)) echo " - FREE!"; ?></h3>
											  <?php else: ?>
											  <h3>Price: <?php echo $plugin->Price; ?> €</h3>
											  <?php endif; ?>											
											  <a class="btn btn-primary" target="_blank" href="<?php echo $plugin->PluginLink; ?>">View More&nbsp;<i class="fa fa-eye"></i></a>
											  </div>
											</div>
								   	</div>	
									
									
									<?php endforeach; endif;?>
		   		
	   	</div>
   	</div>

