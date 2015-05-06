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
	   		<?php 
	   		if(!isset($config['date_format']) || $config['date_format']=="") 
	   			echo '<input type="hidden" name="date_format" value="d-m-y">';
	   		if(!isset($config['portal_theme']) || $config['portal_theme']=="") 
	   			echo '<input type="hidden" name="portal_theme" value="default">';
	   		?>
			   	<div class="col-md-6">				   	
				  <div class="form-group">
				    <label for="admin_user">Portal Administrator Username <span style="color:red">*</span></label>
				    <p class="help-block">This username will be used to access this configuration page.</p>
				    <input type="text" class="form-control" id="admin_user" name="admin_user" value="<?php echo $config['admin_user']; ?>" required >
				  </div>
				  <div class="form-group">
				    <label for="admin_pass">Portal Administrator Password <span style="color:red">*</span></label>
				    <p class="help-block">This is the password for the portal administrator, required to access this configuration page.</p>
				    <input type="password" class="form-control" id="admin_pass" name="admin_pass" value="<?php echo $config['admin_pass']; ?>" required >
				    <p class="help-block passerror_l" style="color:red">Password must contain at least 6 characters!</b></p>
				  </div>
				  <div class="form-group">
				    <p class="help-block">Portal Administrator <b>Password Confirm</b> <span style="color:red">*</span></p>
				    <input type="password" class="form-control" id="admin_pass_confirm" name="" value="<?php echo $config['admin_pass']; ?>" required >
				    <p class="help-block passerror_c" style="color:red">The Passwords doesn't match!</b></p>

				  </div>
				  <div class="form-group">
				    <label for="admin_email">Portal Administrator Email <span style="color:red">*</span></label>
				    <p class="help-block">This is the mail of the portal administrator account, if needed this will be used to reset the password to access this configuration page.</p>
				    <input type="text" class="form-control" id="admin_email" name="admin_email" value="<?php echo $config['admin_email']; ?>" required >
				  </div>
				  <div class="form-group">
				    <label for="vtiger_path">vTiger Path  <span style="color:red">*</span></label>
				    <p class="help-block">This is the vtiger server path, the url to access the vtiger server in browser
<br>Ex. i access my vtiger as http://yourdomain.com:90/yourcrm/index.php so i will give as http://yourdomain.com:90/yourcrm</p>
				    <input type="text" class="form-control" id="vtiger_path" name="vtiger_path" placeholder="http://yourdomain.com:90/yourcrm" value="<?php echo $config['vtiger_path']; ?>" required >
				  </div>
				  <div class="form-group">
				    <label for="upload_dir">Upload Directory  <span style="color:red">*</span></label>
				    <p class="help-block">Give a temporary directory path in this server which is used when customer upload attachment
				    </p>
				    <input type="text" class="form-control" id="upload_dir" name="upload_dir" value="<?php echo ($config['upload_dir'] ? $config['upload_dir'] : '/tmp'); ?>" required>
				  </div>
				  
				
				       	
			   	<div class="form-group">
				    <label for="default_timezone">Default Timezone</label>
				    <p class="help-block">Default timezone settings for the server, set this if you have a bad configured server that shows you warning or if you want to use a different timezone than the server.</p>
				    <select name="default_timezone" id="default_timezone" class="form-control chosen-select" >
				    	<option value=""> - - - - - </option>
				    	<?php foreach($timezones as $tzv => $label) {
				    			$selected="";
				    			if($tzv == $config['default_timezone']) $selected=" selected";
					    		echo "<option value='$tzv' $selected>$label</option>";
					    		}
				    	?>
				    </select>
				  </div>				  
				  
				
				  
				  
				  
				 
		
		
				  
			   	</div>
			   	<div class="col-md-6">	
			   	
			  
				  <div class="form-group">
				    <label for="default_charset">Default Charset  <span style="color:red">*</span></label>
				    <p class="help-block">This is the default charset that will be used to encode and display data exchanged with vTiger</p>
				    <select name="default_charset" id="default_charset" class="form-control" >
				    	<?php 
				    	$charsets=array("UTF-8","ISO-8859-1");
				    	//$charsets=mb_list_encodings();
				    	foreach($charsets as $tzv) {
				    			$selected="";
				    			if($tzv == $config['default_charset']) $selected=" selected";
				    			if(!isset($config['default_charset']) && $tzv == "UTF-8") $selected=" selected";
					    		echo "<option value='$tzv' $selected>$tzv</option>";
					    		}
				    	?>
				    </select>
				  </div>
				  
				  <div class="form-group">
				    <label for="default_language">Default Language</label>
				    <p class="help-block">Set the default language for your portal, the selected will be the first shown in the login picklist. To add a new language to the customer portal you just need to create a new file following the other languages files structure (presents in the language directory) and put it in the language directory with the name your_language.lang.php (replacing your_language with yout language code)</p>				    
				    <select name="default_language" id="default_language" class="form-control" >
				    <?php
				    	   $result = array(); 
						   $themesdir="../languages";
						   $cdir = scandir($themesdir); 
						   foreach ($cdir as $key => $value) 
						      if (!in_array($value,array(".","..")) && strpos($value, '.lang.php') !== false)  
						      		{
						      			$value=str_replace(".lang.php", "", $value); 
						    			$selected="";
						    			if($value == $config['default_language']) $selected=" selected";
						    			$label=Language::translate($value,$value); 
										echo "<option value='$value' $selected>$label</option>";
									}
						    
				    ?>
				    </select>				    
				  </div>
				  
				   
			   	
			
				  			   	
				<hr>
				  <b><em>You should set here your api credentials to enable the api-related functionalities of MYC Customer Portal, for example the Events Calendar</em></b><br><br>
						     <div class="form-group">
							    <label for="api_user">vTiger WS Api Username</label>
							    <p class="help-block">You can set here an existing vtiger user or create a new one in your crm and customize permission and roles for this user, the "api_user" parameter is the login username</p>
							    <input type="text" class="form-control" id="api_user" name="api_user" value="<?php echo $config['api_user']; ?>">
							  </div>
							  <div class="form-group">
							    <label for="api_pass">vTiger WS Api Key</label>
							     <p class="help-block">The api_key could be found in your crm, in the user preferences view for the choosen user (at the bottom of the page, the block before tag cloud)</p>
							    <input type="text" class="form-control" id="api_pass" name="api_pass" value="<?php echo $config['api_pass']; ?>">
							  </div>
							
							  <div class="form-group">
							    <label for="google_api_key">Google Api Key</label>
							     <p class="help-block">Google api key for google maps (you can request your own at <a target="_blank" href="https://code.google.com/apis/console">https://code.google.com/apis/console</a> ) to enable the google maps panel in the event detail view, if no api will be provided the map will be disabled</p>
							    <input type="text" class="form-control" id="google_api_key" name="google_api_key"  value="<?php echo $config['google_api_key']; ?>">
							  </div>
					
				 				 
			   	</div>
	
	<hr>
	
	
			   	
			   	<div class="col-md-12" style="padding-bottom:50px;">
			  
					    
					    <div class="row">
					    <div class="col-md-12 text-center"><button type="submit" id="submbtn" class="btn btn-success btn-lg">Save Configuration</button></div>
						

			   	</div>
			   	
		   	</form>
	   	</div>
	   	</div>
   	</div>
 <script>
	 $(function(){
	 	 $(".passerror_c, .passerror_l").hide();
		 checkPassEgual();
	 })
	 
	 function checkPassEgual(){
	 
	 	if($("#admin_pass").val()=="" || $("#admin_pass").val().length < 6){
		 	$(".passerror_l").show();
		 	$("#submbtn").attr("disabled","disabled");
		}
		else if($("#admin_pass").val()!=$("#admin_pass_confirm").val()){
			$(".passerror_l").hide();
			$(".passerror_c").show();
			$("#submbtn").attr("disabled","disabled");
		}	 
			
		else {
			$("#submbtn").removeAttr("disabled");
			$(".passerror_c, .passerror_l").hide();
		}
	 
		 
	 }
	 
	 $("#admin_pass, #admin_pass_confirm").on("keyup",function(){
		 checkPassEgual();
	 });
 </script>