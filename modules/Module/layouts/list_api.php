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
                    <h1 class="page-header"><?php echo Language::translate($module." List"); ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
                            <?php 
                	if(isset($data['plugin_data']['views']['header']))  
                		foreach($data['plugin_data']['views']['header'] as $pluginname => $viewname)
                			Template::displayPlugin($pluginname,$data,$viewname);
                
                ?> 
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $module; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body text-center">
                        
                        <?php if(isset($data['records']) && count($data['records'])>0){ ?>
                        
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <?php foreach($data['records_columns'] as $hf) 
                                        	echo "<th>".Language::translate($data['moduleinfo']['fieldslabels'][$hf])."</th>"; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    	<?php 
                                    	foreach($data['records'] as $record){
                                    	
                                    			echo "<tr>";
                                    			foreach($data['records_columns'] as $fieldname)  
                                    			
                                    			if($fieldname==$data['moduleinfo']['labelFields'] ||(is_array($data['moduleinfo']['labelFields']) && in_array($fieldname, $data['moduleinfo']['labelFields']))) 
                                    			echo "<td><a href='index.php?module=".$module."&action=index&id=".$record['id']."'>".Language::translate($record[$fieldname])."</a></td>";
                                    			
                                    			elseif(strpos($fieldname,'.')!==false){
	                                    			$fieldparts=explode(".", $fieldname);
	                                    			
	                                    			echo "<td>".Language::translate($record[$fieldparts[0]][$fieldparts[1]]);	                                    			
	                                    			echo "</td>";
                                    			}
                                    			
                                    			elseif(is_array($record[$fieldname])){
	                                    			echo "<td>".Language::translate(reset($record[$fieldname]))."</td>";
                                    			}
                                    			
												else echo "<td>".Language::translate($record[$fieldname])."</td>";
																									                                  
                                    			echo "</tr>";
                                    			 																	
                                    	}
	                                    	
                                    	?>
                                    	                                                                              
                                    </tbody>
                                </table>
                            </div>
                         <?php } else { ?>    
                            <h2><?php echo Language::translate("No ".$module." records Found!"); ?></h2>
                         <?php } ?>   
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
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