<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
 
 ?>
	   		<form role="form" method="post"  enctype="multipart/form-data">
	   		<input type="hidden" name="updateconfig" value="1">
			   	<div class="col-md-6">				   	
				 <div class="form-group">
				    <label for="portal_title">Portal Title</label>
				    <p class="help-block">You should specify the name to show as the page title in your portal (The one shown in the browser tab)</p>
				    <input type="text" class="form-control" id="portal_title" name="portal_title" value="<?php echo $config['portal_title']; ?>"  >
				  </div>
				  
				  <div class="form-group">
				    <label for="default_language">Date Format</label>
				    <p class="help-block">Choose wich format you want to use to show dates to your customers</p>				    
				    <select name="date_format" id="date_format" class="form-control" >
				    <?php 
				    $dateformats=array(
				    	"d-m-Y" => "DD/MM/YYYY",
				    	"m-d-Y" => "MM/DD/YYYY",
				    	"Y-m-d" => "YYYY/MM/DD",
				    );
				    foreach($dateformats as $df => $label) {
				    			$selected="";
				    			if($df == $config['date_format']) $selected=" selected";
					    		echo "<option value='$df' $selected>$label</option>";
					    		}
				    ?>
				    </select>				    
				  </div>
				  
				  
				  <div class="form-group">
				    <label for="portal_logo">Portal Logo</label>		
				    <p class="help-block">Upload here your own logo to display in the login page and at the top of the navigation bar in the portal, we advice you to put your logo in small format and with a size not bigger than 1Mb, a bigger logo could make the portal navigation slow. (The allowed max file size is of 3MB)</p>	
				    
				    <div style="width:100%; border: 3px dashed lightgray; padding:10px;" class="text-center">		    
				    <?php 
				    
				    if(isset($config['portal_logo'])) echo "<img id='logopreview' src='../themes/default/assets/img/".$config['portal_logo']."' style='max-width:100%;margin:auto;'>"; 
				    else echo "<img id='logopreview' src='../themes/default/assets/img/logo-myc.png' style='max-width:100%;margin:auto;'>";
					    
				    ?>
				    </div>
				    <br><br>	    
				    <input type="file" class="" name="portal_logo" id="portal_logo" accept="image/*"  max-size='3145728'>
				    <br>
				    <a class="btn btn-danger btn-xs" id='clearupload'>Reset Logo</a>
				    <script>
					$(function(){
					
						$('#clearupload').click(function(){
						  $("#portal_logo").replaceWith($("#portal_logo").clone(true, true));
						  $('#logopreview').attr('src',	'../themes/default/assets/img/logo-myc.png');					  
						});
						
						$("#portal_logo").change(function(){
						    if (this.files && this.files[0]) {
						        var reader = new FileReader();
						        reader.onload = function (e) {
						            $('#logopreview').attr('src', e.target.result);
						        }
						        reader.readAsDataURL(this.files[0]);
						    }
						});
					
					    $('form').submit(function(){
					        var isOk = true;
					        $('input[type=file][max-size]').each(function(){
					            if(typeof this.files[0] !== 'undefined'){
					                var maxSize = parseInt($(this).attr('max-size'),10),
					                size = this.files[0].size;
					                isOk = maxSize > size;
					                if(!isOk) alert("The size of your logo is bigger than the allowed (3MB), please reduce it and try again!");
					                return isOk;
					            }
					        });
					        return isOk;
					    });
					});
					</script>		    
				  </div>
				  				  
				  
		
		
				  
			   	</div>
			   	<div class="col-md-6">	
			   	
			
				   
			   	
			   	
			   	<div class="checkbox">
				  <p><b>Dashboard Toggle</b></p>
				    <label>
				      <input type="checkbox" value="true" name="show_dashboard" <?php if($config['show_dashboard'] || !isset($config['vtiger_path'])) echo "checked"?>> Enable or Disable the Portal Dashboard feature.
				    </label>
				  </div>
				  
				  <div class="form-group">
				    <label for="default_timezone">Hidden Modules</label>
				    <p class="help-block">Choose which modules you want to force to hide from menu, PAY ATTENTION! this modules will not be disabled but just hidden, to disable it change the customer portal settings in your crm.</p>
				    <select name="hiddenmodules[]" id="hiddenmodules" class="form-control chosen-select" multiple>
				    	<?php $avmod=array("ProjectTask","ProjectMilestone"); foreach($avmod as $tzv) {
				    			$selected="";
				    			if(in_array($tzv,$config['hiddenmodules'])) $selected=" selected";
				    			if(!isset($config['hiddenmodules']) && ($tzv == "ProjectTask" || $tzv == "ProjectMilestone")) $selected=" selected";
					    		echo "<option value='$tzv' $selected>$tzv</option>";
					    		}
				    	?>
				    </select>
		</div>
		
		  <div class="form-group">
				    <label for="portal_theme">Portal Theme</label>		
				    <p class="help-block">Go to the theme manager to set the default theme to apply to the portal, upload new themes zip  direcly from the theme manager and explore new themes available from the store</p>		    
				    <?php if(!isset($config['portal_theme'])) $config['portal_theme']="default"; ?>
				  				    
				    <input type="hidden" name="portal_theme" value="<?php echo $config['portal_theme'] ?>">	
				    <a class="btn btn-primary" href='?action=themes'>Theme Manager</a>	
				    &nbsp;&nbsp;Current Default: <b><?php echo ucfirst($config['portal_theme']) ?></b>    
				  </div>
				 
				
				  
				  					
				 				 
			   	</div>
	
	<hr>
	
	
			   	
			   	<div class="col-md-12" style="padding-bottom:50px;">
			  
					    
					    <div class="row">
					    <div class="col-md-12 text-center"><button type="submit" class="btn btn-success btn-lg">Save Configuration</button></div>
						

			   	</div>
		   	</form>
	   	</div>
	   	</div>
   	</div>