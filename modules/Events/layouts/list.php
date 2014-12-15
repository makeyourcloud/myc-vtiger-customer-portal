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
                    <h1 class="page-header"><?php echo Language::translate("Events List"); ?> 
                    <div class="btn-group pull-right" role="group" aria-label="View Mode">
					  <button type="button" class="btn btn-primary" onclick="window.location = 'index.php?module=Events&action=index'">Calendar Mode</button>
					  <button type="button" class="btn btn-info selected active" disabled >List Mode</button>
					</div>

                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $module; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body text-center">
                        
                        <?php if(isset($data['events']) && count($data['events'])>0){ ?>
                        
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                        <?php foreach($data['events_columns'] as $hf) echo "<th>".Language::translate($hf)."</th>"; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    	<?php 
                                    	
                                    	foreach($data['events'] as $record){
                                    	
											 $datas = new DateTime($record['date_start']." ".$record['time_start'], new DateTimeZone('GMT'));			 
											 $datae = new DateTime($record['due_date']." ".$record['time_end'], new DateTimeZone('GMT'));
											 
											 if(isset($_REQUEST['tz'])){
												 $datas->setTimezone(new DateTimeZone($_REQUEST['tz'])); 
												 $datae->setTimezone(new DateTimeZone($_REQUEST['tz'])); 
												 $record['date_start']=$datas->format('d/m/Y');
												 $record['time_start']=$datas->format('H:i');
												 $record['due_date']=$datae->format('d/m/Y');
												 $record['time_end']=$datae->format('H:i');
											 }
											 	$trclass="";
											 	if(new DateTime() > $datas) $trclass="class='warning'";
                                    			echo "<tr $trclass>";
                                    			foreach($record as $fieldname => $record_val) if(in_array($fieldname, $data['events_columns'])) { 
                                    			if($fieldname==$GLOBALS['api_modules'][$module]['link_field']) 
                                    			echo "<td><a href='index.php?module=".$module."&action=index&id=".$record['id']."'>".Language::translate($record_val)."</a></td>";
                                    			
												else echo "<td>".Language::translate($record_val)."</td>";
	                                    			
                                    			}
                                    			
                                    			
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
            
		</div>
        <!-- /#page-wrapper -->
         <script>
	    $(document).ready(function() {
	        $('#dataTables-example').dataTable();
	    });
	    </script>