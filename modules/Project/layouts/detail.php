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
                    <h1 class="page-header"><?php echo Language::translate($module); ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
                                      <?php 
                	if(isset($data['plugin_data']['views']['header']))  
                		foreach($data['plugin_data']['views']['header'] as $pluginname => $viewname)
                			Template::displayPlugin($pluginname,$data,$viewname);
                
                ?> 
            
          <div class="row">
             
  <?php if(isset($data['recordinfo']) && count($data['recordinfo'])>0 && $data['recordinfo']!=""){ foreach($data['recordinfo'] as $blockname => $tblocks): ?>
            <div class="col-lg-6">
            
               
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo Language::translate($blockname); ?>
                        </div>
                        
                        
                        <table class="table">
                        	<?php
                        	
                        		foreach($tblocks as $field){
		                        	echo "<tr><td><b>".Language::translate($field['label']).": </b></td><td>".$field['value']."</td></tr>";
		                        }
	                       
                        	?>
						    
						</table>

                            
                            
                    </div>
                    <!-- /.panel -->
               
               </div>
                <!-- /.col-lg-6 -->
                
                <?php endforeach;  ?>
                
                                          <?php 
                	if(isset($data['plugin_data']['views']['blocks']))  
                		foreach($data['plugin_data']['views']['blocks'] as $pluginname => $viewname)
                			Template::displayPlugin($pluginname,$data,$viewname);
                
                ?> 
                     
                  <div class="col-lg-12">
            
               
                    <div class="panel panel-default">
                  <div class="panel-heading">
                            <?php echo Language::translate("Project Related Tickets"); ?>
                            <div class="input-group pull-right">
                                <a href="index.php?module=HelpDesk&action=new&projectid=<?php echo $data['recordid']; ?>" class="btn btn-warning btn-sm pull-right"><?php echo Language::translate("New Ticket"); ?></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>   
                           
                  <?php if(isset($data['relatedticketlist']) && count($data['relatedticketlist'])>0 && $data['relatedticketlist']!=""): ?>  
                  
                  <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables" >
                                    <thead>
                                        <tr>
                                        <?php foreach($data['relatedtickettableheader'] as $hf) echo "<th>".Language::translate($hf['fielddata'])."</th>"; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    	<?php 
                                    	foreach($data['relatedticketlist'] as $record){
                                    	
                                    			echo "<tr>";
                                    			foreach($record as $record_fields) echo "<td>".Language::translate($record_fields['fielddata'])."</td>";
                                    			echo "</tr>";
                                    			 																	
                                    	}
	                                    	
                                    	?>
                                    	                                                                              
                                    </tbody>
                                </table>
                            </div>
                
                  <?php endif; ?>
				  	</div>
                  </div>


                  
                  <?php if(isset($data['relatedtaskslist']) && count($data['relatedtaskslist'])>0 && $data['relatedtaskslist']!=""): ?>  
                  <div class="col-lg-12">
            
               
                    <div class="panel panel-default">
                  <div class="panel-heading">
                            <?php echo Language::translate("Project Related Tickets"); ?>
                        </div>
                  <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables" >
                                    <thead>
                                        <tr>
                                        <?php foreach($data['relatedtaskstableheader'] as $hf) echo "<th>".Language::translate($hf['fielddata'])."</th>"; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    	<?php 
                                    	foreach($data['relatedtaskslist'] as $record){
                                    	
                                    			echo "<tr>";
                                    			foreach($record as $record_fields) echo "<td>".Language::translate($record_fields['fielddata'])."</td>";
                                    			echo "</tr>";
                                    			 																	
                                    	}
	                                    	
                                    	?>
                                    	                                                                              
                                    </tbody>
                                </table>
                            </div>
                  </div>
                  </div>
                   
                  
                  <?php endif; ?>
                  
                  <?php if(isset($data['relatedmilestoneslist']) && count($data['relatedmilestoneslist'])>0 && $data['relatedmilestoneslist']!=""): ?>  
                  <div class="col-lg-12">
            
               
                    <div class="panel panel-default">
                  <div class="panel-heading">
                            <?php echo Language::translate("Project Related Milestones"); ?>
                        </div>
                  <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables" >
                                    <thead>
                                        <tr>
                                        <?php foreach($data['relatedmilestonestableheader'] as $hf) echo "<th>".Language::translate($hf['fielddata'])."</th>"; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    	<?php 
                                    	foreach($data['relatedmilestoneslist'] as $record){
                                    	
                                    			echo "<tr>";
                                    			foreach($record as $record_fields) echo "<td>".Language::translate($record_fields['fielddata'])."</td>";
                                    			echo "</tr>";
                                    			 																	
                                    	}
	                                    	
                                    	?>
                                    	                                                                              
                                    </tbody>
                                </table>
                            </div>
                  </div>
                  </div>
                   
                  
                  <?php endif; ?>
                
                <?php } else echo "<div class='col-lg-12'><h2>".Language::translate("The record could not be found!")."</h2></div>"; ?>
                
           
                
                                    </div>
                <!-- /.row -->
           
           
                                     <?php 
                	if(isset($data['plugin_data']['views']['footer']))  
                		foreach($data['plugin_data']['views']['footer'] as $pluginname => $viewname)
                			Template::displayPlugin($pluginname,$data,$viewname);
                
                ?> 
           
           
            
            
		</div>
        <!-- /#page-wrapper -->
         <script>
	    $(document).ready(function() {
	        $('#dataTables-example').dataTable();
	    });
	    </script>