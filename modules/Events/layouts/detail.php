<?php
/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
?>
<script src="modules/Events/layouts/src/jstz.min.js"></script>
<script>
var timezone = jstz.determine();
if('<?php echo $_REQUEST['tz']?>'!=timezone.name())
	window.location=window.location+"&tz="+timezone.name();
</script>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo Language::translate("Event Title"); ?>: <?php echo $data['event']['subject']; ?>
                    <div class="btn-group pull-right" role="group" aria-label="View Mode">
					  <button type="button" class="btn btn-primary" onclick="window.location = 'index.php?module=Events&action=index'">Calendar Mode</button>
					  <button type="button" class="btn btn-info" onclick="window.location = 'index.php?module=Events&action=index&list_mode=1'" >List Mode</button>
					</div>
                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
          <div class="row">

            
                <div class="col-lg-6">
                    
                                        					                   
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo Language::translate("Event Type"); ?>
                        </div>
                        
                        <div class="panel-body text-center">
                        	<?php
							echo "<h2>".$data['event']['activitytype']."</h2>";
                        	?>
						    
						</div>
         
                    </div>
                    
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo Language::translate("Event Description"); ?>
                        </div>
                        
                        <div class="panel-body">
                        	<?php
                        	if($data['event']['description']!="")echo $data['event']['description'];
							else echo Language::translate("Event Description not Provided");
                        	?>
						    
						</div>
         
                    </div>
                    
                    
                </div>
                <!-- /.col-lg-6 -->
                
                
                
                
                 <div class="col-lg-6">
                
                
                    
                   <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo Language::translate("Event Date"); ?>
                        </div>
                        
                        
                        <div class="panel-body text-center">
                        	<?php
							 $datas = new DateTime($data['event']['date_start']." ".$data['event']['time_start'], new DateTimeZone('GMT'));						 
							 $datae = new DateTime($data['event']['due_date']." ".$data['event']['time_end'], new DateTimeZone('GMT'));
							 
							 if(isset($_REQUEST['tz'])){
								 $datas->setTimezone(new DateTimeZone($_REQUEST['tz'])); 
								 $datae->setTimezone(new DateTimeZone($_REQUEST['tz'])); 
							 }							                         	
                        	 echo "<h2>Start: ".$datas->format('d/m/Y H:i')."</h2>";
                        	 echo "<h3>End: ".$datae->format('d/m/Y H:i')."</h3>";
                        	?>
						    
						</div>

                            
                            
                    </div>  
                    
                    <?php 
                switch ($data['event']['eventstatus']) {

				    case "Planned":
				        $panelcolor="primary";
				        break;
				    case "Held":
				        $panelcolor="green";
				        break;
				    case "Not Held":
				        $panelcolor="red";
				        break;
				}
                ?>
                
                <div class="panel panel-<?php echo $panelcolor; ?>">
                        <div class="panel-heading">
                            <div class="text-center">
                            <?php echo Language::translate("Event Status"); ?>
                            <div class="huge"><?php echo Language::translate($data['event']['eventstatus']); ?></div>
                            </div>
                        </div>
                    </div>
                    
                                  
                </div>
                <!-- /.col-lg-6 -->



<?php if($data['event']['location']!=""): ?>
<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo Language::translate("Event Location"); ?>
                        </div>
                        
                        <div class="panel-body text-center">
                        	<?php
                        	echo "<h3>".$data['event']['location']."</h3>";
                        	?>
                        
                        <?php if(isset($GLOBALS['google_api_key']) && $GLOBALS['google_api_key']!=""): ?>	
						<iframe
						  width="100%"
						  height="450"
						  frameborder="0" style="border:0"
						  src="https://www.google.com/maps/embed/v1/place?key=<?php echo $GLOBALS['google_api_key']."&q=".$data['event']['location']?>">
						</iframe>
						<?php endif; ?> 
						    
						</div>
         
                    </div>
 </div>                   
                    <?php endif; ?>






                
                
                 </div>
                <!-- /.row -->
           
                     
            
		</div>
  