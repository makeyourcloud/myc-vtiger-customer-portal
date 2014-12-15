<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MYC Portal - Configuration Editor</title>

    <!-- Bootstrap -->
    <link href="../themes/default/assets/css/bootstrap.min.css" rel="stylesheet">
    
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
  <body>
   
   	
   	<div class="container">
	   	<div class="row">
	   		<div class="col-md-12 text-center">
	   			<?php if(!isset($_GET['e'])): ?>
	   			<a class="btn btn-warning pull-right" style="margin-top: 20px;" href="?logout=1">Logout</a>
	   			<?php endif; ?>
	   			
	   			<h1>MYC vTiger Customer Portal</h1>
	   			<h4>Configuration Editor</h4>   			
	   			<?php if (isset($altmess) && $altmess=="OK"): ?><div class="alert alert-success" role="alert">Your configuration has been saved correctly! </div>
	   			<?php elseif(count($config)==0): ?>
	   			<div class="alert alert-danger" role="alert"><b>Your configuration is not correct or you don't have yet configured this installation, You should set the parameters below to complete the MYC Customer Portal setup!</b><br> Is important to set an administrator username and password to restrict the access to this page, if an admin username is set, the next time will be shown a login page and you must insert the administration credentials to continue.
		   			You can access this configuration page when you need at the address http://yourportaladdress.com/configuration
	   			</div>
	   			
	   			<?php elseif(isset($_GET['pe'])): ?>
	   			<div class="alert alert-danger" role="alert">The vTiger Path you specified seems to be not working, please ensure that you provided the correct vTiger installation path and that customer portal is enabled and configured in your crm!
	   			</div>
	   			<?php endif; ?>
	   			
	   			<hr>
	   		</div>
	   		<form role="form" method="post"  enctype="multipart/form-data">
			   	<div class="col-md-6">				   	
				  <div class="form-group">
				    <label for="vtiger_path">Portal Administrator Username <span style="color:red">*</span></label>
				    <p class="help-block">This username will be used to access this configuration page.</p>
				    <input type="text" class="form-control" id="admin_user" name="admin_user" value="<?php echo $config['admin_user']; ?>" required >
				  </div>
				  <div class="form-group">
				    <label for="vtiger_path">Portal Administrator Password <span style="color:red">*</span></label>
				    <p class="help-block">This is the password for the portal administrator, required to access this configuration page.</p>
				    <input type="text" class="form-control" id="admin_pass" name="admin_pass" value="<?php echo $config['admin_pass']; ?>" required >
				  </div>
				  <div class="form-group">
				    <label for="vtiger_path">Portal Administrator Email <span style="color:red">*</span></label>
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
				    <label for="default_charset">Default Charset  <span style="color:red">*</span></label>
				    <p class="help-block">This is the default charset that will be used to encode and display data exchanged with vTiger</p>
				    <select name="default_charset" id="default_charset" class="form-control chosen-select" >
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
				  
				  
				  <div class="form-group">
				    <label for="default_language">Default Language</label>
				    <p class="help-block">Set the default language for your portal, the selected will be the first shown in the login picklist. To add a new language to the customer portal you just need to create a new file following the other languages files structure (presents in the language directory) and put it in the language directory with the name your_language.lang.php (replacing your_language with yout language code)</p>				    
				    <select name="default_language" id="default_language" class="form-control" >
				    <?php
				    	   $result = array(); 
						   $themesdir="../language";
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
		
		
				  
			   	</div>
			   	<div class="col-md-6">	
			   	
			
				   
			   	
			   	
			   	<div class="checkbox">
				  <p><b>Dashboard Toggle</b></p>
				    <label>
				      <input type="checkbox" value="true" name="show_dashboard" <?php if($config['show_dashboard'] || !isset($config['vtiger_path'])) echo "checked"?>> Enable or Disable the Portal Dashboard feature.
				    </label>
				  </div>
				  			   	
				  <div class="form-group">
				    <label for="portal_theme">Portal Theme</label>		
				    <p class="help-block">Go to the theme manager to set the default theme to apply to the portal, upload new themes zip  direcly from the theme manager and explore new themes available from the store</p>		    
				    <?php if(!isset($config['portal_theme'])) $config['portal_theme']="default"; ?>
				  				    
				    <input type="hidden" name="portal_theme" value="<?php echo $config['portal_theme'] ?>">	
				    <a class="btn btn-primary" href='?action=themes' target="_blank">Theme Manager</a>	
				    &nbsp;&nbsp;Current Default: <b><?php echo ucfirst($config['portal_theme']) ?></b>    
				  </div>
				 
				  <div class="form-group">
				    <label for="portal_logo">Portal Logo</label>		
				    <p class="help-block">Upload here your own logo to display in the login page and at the top of the navigation bar in the portal, we advice you to put your logo in small format and with a size not bigger than 1Mb, a bigger logo could make the portal navigation slow. (The allowed max file size is of 3MB)</p>	
				    
				    <div style="width:100%;" class="text-center">		    
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
							    <label for="default_timezone">vTiger Ws Enabled Modules</label>
							    <p class="help-block">Choose which from the availables vTiger WS Modules you would like to enable.</p>
							    <select name="enabled_api_modules[]" id="enabled_api_modules" class="form-control chosen-select" multiple>
							    	<?php foreach($apimodules as $modname => $modfields) {
							    			$selected="";
							    			if(in_array($modname, $config['enabled_api_modules'])) $selected=" selected";
							    			if(!isset($config['hiddenmodules']) && ($modname == "Events")) $selected=" selected";

								    		echo "<option value='$modname' $selected>$modname</option>";
								    		}
							    	?>
							    </select>
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
					    <div class="col-md-12 text-center"><button type="submit" class="btn btn-success btn-lg">Save Configuration</button></div>
						

			   	</div>
			   	
		   	</form>
	   	</div>
   	</div>
   	

  </body>
<script>

$(function(){
	$(".chosen-select").chosen({disable_search_threshold: 10});	
})

</script>

</html>