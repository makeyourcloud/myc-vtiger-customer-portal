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
            
          <div class="row">
             
  <?php if(isset($data['record']) && count($data['record'])>0 && $data['record']!=""){ foreach($data['records_columns'] as $blockname => $tblocks): ?>
            <div class="col-lg-6">
            
               
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo Language::translate($blockname); ?>
                        </div>
                        
                        
                        <table class="table">
                        	<?php
                        	
                        		foreach($tblocks as $field){
		                        	echo "<tr><td><b>".Language::translate($field).": </b></td><td>".$data['record'][$field]."</td></tr>";
		                        }
	                       
                        	?>
						    
						</table>

                            
                            
                    </div>
                    <!-- /.panel -->
               
               </div>
                <!-- /.col-lg-6 -->
                
                <?php endforeach;  ?>
                           
                    
                   
                     
                
                <?php } else echo "<div class='col-lg-12'><h2>".Language::translate("The record could not be found!")."</h2></div>"; ?>
                
           
                
                                    </div>
                <!-- /.row -->
           
           
           
           
           
            
            
		</div>
        <!-- /#page-wrapper -->
         <script>
	    $(document).ready(function() {
	        $('#dataTables-example').dataTable();
	    });
	    </script>