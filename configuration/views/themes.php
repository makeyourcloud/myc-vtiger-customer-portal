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
	   			<a class="btn btn-warning  pull-right" style="margin-top: 20px;" href="?logout=1">Logout</a>
	   			<?php endif; ?>
	   			
	   			<h1>MYC vTiger Customer Portal</h1>
	   			<h4>Theme Manager</h4>   			
	   			<?php if (isset($altmess) && $altmess=="OK"): ?><div class="alert alert-success" role="alert">Your configuration has been saved correctly! </div>
	   			<?php elseif(count($config)==0): ?>
	   			<div class="alert alert-danger" role="alert"><b>Your configuration is not correct or you don't have yet configured this installation, You should set the parameters below to complete the MYC Customer Portal setup!</b><br> Is important to set an administrator username and password to restrict the access to this page, if an admin username is set, the next time will be shown a login page and you must insert the administration credentials to continue.
		   			You can access this configuration page when you need at the address http://yourportaladdress.com/configuration
	   			</div>
	   			<?php echo "<h2>Complete your installation to access the theme manager!</h2>"; die(); ?>
	   			<?php elseif(isset($_GET['pe'])): ?>
	   			<div class="alert alert-danger" role="alert">The vTiger Path you specified seems to be not working, please ensure that you provided the correct vTiger installation path and that customer portal is enabled and configured in your crm!
	   			</div>
	   			<?php echo "<h2>Complete your installation to access the theme manager!</h2>"; die(); ?>
	   			<?php endif; ?>
	   			
	   			<hr>
	   			
	   			<h2>Installed Themes</h2>
	   			
	   		</div>
	   		
	   		
	   		<?php
	   		
				$result = array(); 
				$themesdir="../themes";
				$cdir = scandir($themesdir); 
				foreach ($cdir as $key => $value) 
					if (!in_array($value,array(".","..")) && is_dir($themesdir."/".$value)){
				    	$selected=false;
							if($value == $config['portal_theme']) $selected=true; 
							?>
							
							
								   		<div class="col-md-4 text-center">
									   		<div class="panel panel-default <?php if($selected) echo "panel-primary"; ?>">
											  <div class="panel-heading">
											    <h3 class="panel-title"><?php echo ucfirst($value); ?></h3>
											  </div>
											  <div class="panel-body text-center">
											  <?php if(file_exists("../themes/".$value."/preview.png")): ?>
											    <img style="max-width:100%;" src="../themes/<?php echo $value; ?>/preview.png">
											  <?php else: ?>
											  	<h3> No preview available for this theme!</h3>
											  <?php endif; ?>  
											  <?php if(!$selected): ?>
											  <br><br>
											  <a class="btn btn-warning" href="../index.php?theme=<?php echo $value; ?>" target="_blank">Preview&nbsp;<i class="fa fa-eye"></i></a>
											  <a class="btn btn-primary" href="?action=themes&deftheme=<?php echo $value; ?>">Set as Default&nbsp;<i class="fa fa-star-o"></i></a> 
											  <?php else: ?>
											  <br><br>
											  <a class="btn btn-default disabled">Current Default Theme&nbsp;<i class="fa fa-star"></i></a>
											  <?php endif; ?>
											  </div>
											</div>
								   		</div>
	   		
							
							<?php
					}
						    
			?>

										<div class="col-md-4 text-center">
									   		<div class="panel panel-default panel-info">
											  <div class="panel-heading">
											    <h3 class="panel-title">Theme Upload</h3>
											  </div>											  
											  <div class="panel-body text-center" style="min-height:300px;">
											  <br><i onclick="$('.upload').trigger('click');" class="fa fa-plus" style="font-size:10em;color:grey;cursor:pointer;"></i><br>
											    <form enctype="multipart/form-data" method="post">
												    <div class="text-center">
													    <label>Upload New Theme Zip or Theme Upgrade</label>
													    <p class="help-block">A theme Upgrade will replace all your current modification for the selected theme</p>
													    <input name="theme_zip" type="file" class="form-control" accept="application/zip" >
													    <br>
													    <input type="submit" class="btn btn-success" value="Upload and Refresh">
													</div>
												</form>
											  </div>
											</div>
								   		</div>
								   		
								
								 
								 	<?php
									$themes = @simplexml_load_file("http://makeyourcloud.com/store/themes-xml.php");
									if(isset($themes[0])): 		
									?>
									<div class="col-md-12 text-center"> 
									 <hr> 		
									   	<h2>Themes Available in our Store</h2>
									 </div>
										
									<?							
								    foreach($themes as $theme):
									?>
									
									<div class="col-md-4 text-center">
									   		<div class="panel panel-default">
											  <div class="panel-heading">
											    <h3 class="panel-title"><?php echo $theme->Name; ?></h3>
											  </div>
											  <div class="panel-body text-center">
											    <img style="max-width:100%;" src="<?php echo $theme->PreviewImg; ?>">
											  <br><br>
											  <p>
												  <?php echo $theme->ShortDesc; ?>
											  </p>
											  
											  <?php if(floatval($theme->SalePrice)!=floatval($theme->Price)): ?>
											  <h4><s style="color:red;">Old Price: <?php echo $theme->Price; ?> €</s></h4>
											  <h3>Promo Price: <?php echo $theme->SalePrice; ?> €<?php if(floatval($theme->SalePrice==0)) echo " - FREE!"; ?></h3>
											  <?php else: ?>
											  <h3>Price: <?php echo $theme->Price; ?> €</h3>
											  <?php endif; ?>											
											  <a class="btn btn-primary" target="_blank" href="<?php echo $theme->ThemeLink; ?>">View More&nbsp;<i class="fa fa-eye"></i></a>
											  </div>
											</div>
								   	</div>	
									
									
									<?php endforeach; endif;?>
		   		
	   	</div>
   	</div>
   	

  </body>
<script>

$(function(){
	$(".chosen-select").chosen({disable_search_threshold: 10});	
})

</script>


</html>