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
                    <h1 class="page-header"><?php echo Language::translate("Ticket No"); ?>: <?php echo $data['ticketno']; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
                                      <?php 
                	if(isset($data['plugin_data']['views']['header']))  
                		foreach($data['plugin_data']['views']['header'] as $pluginname => $viewname)
                			Template::displayPlugin($pluginname,$data,$viewname);
                
                ?> 
          <div class="row">
            
  <?php foreach($data['ticket_infos'] as $blockname => $tblocks): ?>
            
            
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo Language::translate($blockname); ?>
                        </div>
                        
                        
                        <table class="table">
                        	<?php
                        	
                        		foreach($tblocks as $field){
		                        	echo "<tr><td><b>".Language::translate($field['label']).": </b></td><td>".Language::translate($field['value'])."</td></tr>";
		                        }
	                       
                        	?>
						    
						</table>

                            
                            
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
                
                <?php endforeach; ?>
                
                
                
                
                
       
                <div class="col-lg-6">
                
                <?php 
                switch ($data['ticket_status']) {
				    case "Open":
				        $panelcolor="yellow";
				        break;
				    case "In Progress":
				        $panelcolor="primary";
				        break;
				    case "Closed":
				        $panelcolor="green";
				        break;
				    case "Wait For Response":
				        $panelcolor="red";
				        break;
				}
                ?>
                
                <div class="panel panel-<?php echo $panelcolor; ?>">
                        <div class="panel-heading">
                            <div class="text-center">
                            <?php echo Language::translate("Ticket Status"); ?>
                            <div class="huge"><?php echo Language::translate($data['ticket_status']); ?></div>
                            </div>
                        </div>
                       <?php if($data['ticket_status']!="Closed"): ?> 
                        <a href="index.php?module=HelpDesk&action=index&fun=close_ticket&ticketid=<?php echo $data['ticketid']; ?>">
                            <div class="panel-footer text-center">
                                <b><?php echo Language::translate("Close Ticket"); ?></b>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                        <?php endif; ?>
                    </div>
                
                      
                
                    
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo Language::translate("Attachments"); ?>
                        </div>
                        
                        <table class="table">
                        	<?php 
                        	if(isset($data['attachments']) && count($data['attachments'])>0 && $data['attachments']!="") foreach($data['attachments'] as $cat){
	                        	echo '<tr><td><h5>'.ltrim($cat['filename'],$_REQUEST['ticketid'].'_').'</h5></td><td><a class="btn btn-success btn-sm"  href="index.php?downloadfile=true&fileid='.$cat['fileid'].'&filename='.$cat['filename'].'&filetype='.$cat['filetype'].'&filesize='.$cat['filesize'].'&ticketid='.$_REQUEST['ticketid'].'">Download</a></td></tr>';
                        	}
                        	//print_r($data['attachments']);
                        	?>
						    
						</table>
						
						<?php if($data['ticket_status']!="Closed"): ?>
                            
                            <div class="panel-footer">
                            
                            <?php if(isset($data['uploadres'])): ?>
                            <?php if($data['uploadres']!=""): ?>
                            <div class="alert alert-danger" role="alert"><?php echo Language::translate($data['uploadres']); ?></div>
                            <?php else: ?>
                            <div class="alert alert-success" role="alert"><?php echo Language::translate("UPLOAD_COMPLETED"); ?></div>
                            <?php endif; ?>
                            
                            <?php endif; ?>
                            
                            <form name="fileattachment" method="post" enctype="multipart/form-data" action="index.php">
							<input type="hidden" name="module" value="HelpDesk">
							<input type="hidden" name="action" value="index">
							<input type="hidden" name="fun" value="uploadfile">
							<input type="hidden" name="ticketid" value="<?php echo $data['ticketid']; ?>'">
							<input type="hidden" name="customerfile_hidden"/>
			
                            
                            <div class="input-group">
                            
                                <input id="btn-input" type="file" name="customerfile" class="form-control input-sm" placeholder="<?php echo Language::translate("Upload"); ?>..." onchange="validateFilename(this)" >
                                <span class="input-group-btn">
                                    <button class="btn btn-warning btn-sm" id="btn-chat" type="submit">
                                        <?php echo Language::translate("Upload"); ?>
                                    </button>
                                </span>
                            </div>
                            
                            </form>
                        </div>
                        <!-- /.panel-footer -->
                        <?php endif; ?>
                    </div>
                    <!-- /.panel -->



                    </div>
                <!-- /.col-lg-6 -->
                
                                    </div>
                <!-- /.row -->
           
           
           
           
           
                      <div class="row">   
                
                <div class="col-lg-12">
                
                <div class="chat-panel panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-comments fa-fw"></i>
                            <?php echo Language::translate("Ticket Comments"); ?>
                            
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body" style="height: auto; max-height: 350px;">
                        
                       
                            <ul class="chat">
                            
                             <?php if(isset($data['commentresult']) && count($data['commentresult'])>0  && $data['commentresult']!="")  foreach($data['commentresult'] as $comment): ?>
                                <li class="left clearfix">
                                    <div class="">
                                        <div class="header">
                                            <strong class="primary-font"><?php echo $comment['owner']; ?></strong> 
                                            <small class="pull-right text-muted">
                                                <i class="fa fa-clock-o fa-fw"></i> <?php echo $comment['createdtime']; ?>
                                            </small>
                                        </div>
                                        <p>
                                            <?php echo $comment['comments']; ?>
                                        </p>
                                    </div>
                                </li>
                                 <?php endforeach; ?>
                             </ul>
                        </div>
                        <!-- /.panel-body -->
                        
                        <?php if($data['ticket_status']!="Closed"): ?>
                        <div class="panel-footer">
                        <form name="comments" action="index.php" method="post">
		   <input type="hidden" name="module" value="HelpDesk">
		   <input type="hidden" name="action" value="index">
		   <input type="hidden" name="fun" value="updatecomment">
		   <input type="hidden" name="ticketid" value='<?php echo $data['ticketid']; ?>'>
		   <textarea name="comments" rows="5" class="form-control input-sm" ></textarea>
		   <br>
		   <input class="btn btn-warning btn-sm" title="Send Comment" accesskey="S"  name="submit" value="<?php echo Language::translate("Send Comment"); ?>" type="submit" onclick="if(trim(this.form.comments.value) != '') return true; else return false;" />
		   </form>
                        
                        </div>
                        <!-- /.panel-footer -->
                        <?php endif; ?>
                    </div>
                  
                </div>
                <!-- /.col-lg-6 -->
                
                
                                          <?php 
                	if(isset($data['plugin_data']['views']['blocks']))  
                		foreach($data['plugin_data']['views']['blocks'] as $pluginname => $viewname)
                			Template::displayPlugin($pluginname,$data,$viewname);
                
                ?> 
                
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