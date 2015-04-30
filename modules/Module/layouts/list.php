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
                    <h1 class="page-header"><?php echo Language::translate($module); ?> </h1>
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
                        
                        <?php if(isset($data['recordlist']) && count($data['recordlist'])>0){ ?>
                        
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <?php foreach($data['tableheader'] as $hf) echo "<th>".Language::translate($hf['fielddata'])."</th>"; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    	<?php 
                                    	foreach($data['recordlist'] as $record){
                                    	
                                    			echo "<tr>";
                                    			foreach($record as $record_fields) echo "<td>".Language::translate($record_fields['fielddata'])."</td>";
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