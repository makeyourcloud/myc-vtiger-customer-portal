<?php
/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo Language::translate("Dashboard"); ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
     
                               <?php 
                	if(isset($data['plugin_data']['views']['header']))  
                		foreach($data['plugin_data']['views']['header'] as $pluginname => $viewname)
                			Template::displayPlugin($pluginname,$data,$viewname);
                
                ?> 
            
          <div class="row">
             
  <?php if(isset($data['dashboarddata']) && count($data['dashboarddata'])>0 && $data['dashboarddata']!=""){ foreach($data['dashboarddata'] as $modname => $modinfos): ?>
            <div class="col-lg-4">
            
               
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                            
                            <h3><?php echo Language::translate($modname); ?>&nbsp;<small><a class="btn btn-sm btn-info" href="index.php?module=<?php echo $modname; ?>&action=index">View All ( <?php echo $modinfos['count']; ?> )</a></small></h3>
                        </div>
                        
                        
                        <table class="table">
                        	<?php
                        	
                        		foreach($modinfos as $info => $val){
		                        	if($info!="count")
		                        	echo "<tr class='text-center'><td>
		                        	
		                        	<div>
										<p class='text-primary' style='font-size:50px;font-weight:bolder;'>".$val."</p>
										<p class='lead'>".Language::translate($info)."</p>
									</div>
									
		                        	</td></tr>";
		                        }
	                       
                        	?>
						    
						</table>

                            
                            
                    </div>
                    <!-- /.panel -->
               
               </div>
                <!-- /.col-lg-6 -->
                
                <?php endforeach;  ?>
                           
                    
                   
                     
                
                <?php } else echo "<div class='col-lg-12'><h2>".Language::translate("No dashboard infos found!")."</h2></div>"; ?>
                
           
                
                                    </div>
                <!-- /.row -->
           
           
           
                                     <?php 
                	if(isset($data['plugin_data']['views']['footer']))  
                		foreach($data['plugin_data']['views']['footer'] as $pluginname => $viewname)
                			Template::displayPlugin($pluginname,$data,$viewname);
                
                ?> 
           
            
            
		</div>
        <!-- /#page-wrapper -->