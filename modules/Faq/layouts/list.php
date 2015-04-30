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
         <div class="col-lg-12">  
         <h3><?php echo Language::translate("Categories"); ?></h3>
         </div>
         <div class="col-lg-3">  
            <ul class="list-group" role="tablist">
             <?php $ct=0; foreach($data['faqcategories'] as $fq): ?>
             	<li class="list-group-item <?php if($ct==0) echo "active"; ?>"><a href="#p<?php echo $ct; ?>" role="tab" data-toggle="tab"><?php echo $fq; ?></a></li>
             <?php $ct++; endforeach; ?> 
</ul>
         </div>
                <div class="col-lg-9">
                        <div class="tab-content">      
                          <?php $ct=0; foreach($data['faqcategories'] as $fq): ?>
						  <div class="tab-pane <?php if($ct==0) echo "active"; ?>" id="p<?php echo $ct; ?>">
							  	
							  	<div id="accordion">
                            
                            <?php if(isset($data['faqs'][$fq]) && count($data['faqs'][$fq])>0 && $data['faqs'][$fq]!=""): foreach($data['faqs'][$fq] as $faq): ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $faq['id']; ?>"><?php echo $faq['faqno']." - ".$faq['question']; ?></a>
                                        </h4>
                                    </div>
                                    <div id="<?php echo $faq['id']; ?>" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                        	
                                        	<h4><?php echo Language::translate("Answer"); ?>: </h4>
                                            <p><?php echo $faq['answer']; ?></p>
                                            <br>
                                            
                                                                                    	<?php if(isset($data['faqproducts'][$faq['product_id']])): ?>
                                        	<h4><?php echo Language::translate("Related Product"); ?>: <?php echo $data['faqproducts'][$faq['product_id']]['productname']; ?></h4>
                                        	<?php endif; ?>


                                            <div class="row">
	                                            <?php if(isset($faq['attachments'])): 
	                                            		echo "<div class='col-md-12'><h4>".Language::translate("Attachments").":</h4></div>";
	                                            		foreach($faq['attachments'] as $doc) 
	                                            		echo "<div class='col-md-3 dwbtn'>".$doc[1]['fielddata']."</div>";
	                                            	
	                                                  endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              <?php endforeach; else: ?>  
                                <h3><?php echo Language::translate("Sorry... No F.A.Q. in this Category!"); ?></h3>
                                <?php endif; ?>
                           </div>
							  
						  </div>
						  <?php $ct++; endforeach; ?>
						  
						</div>
                            
                </div>                <!-- /.col-lg-12 -->
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
	        $('.dwbtn > a').attr("class","btn btn-lg btn-info");
	        $('.dwbtn > a').prepend('<i class="fa fa-eye"></i>&nbsp;|&nbsp;');
	    });
	    
	    
	    </script>