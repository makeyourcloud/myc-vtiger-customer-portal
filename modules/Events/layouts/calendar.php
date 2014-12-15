<?php
/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
?>

<script src="modules/Events/layouts/src/moment.min.js"></script>
<link href="modules/Events/layouts/src/fullcalendar.css"  rel="stylesheet">
<script src="modules/Events/layouts/src/fullcalendar.min.js"></script>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                                    
                    <h1 class="page-header"><?php echo Language::translate("Events Calendar"); ?>
                    
                    <div class="btn-group pull-right" role="group" aria-label="View Mode">
					  <button type="button" class="btn btn-primary selected active" disabled>Calendar Mode</button>
					  <button type="button" class="btn btn-info" onclick="window.location = 'index.php?module=Events&action=index&list_mode=1'">List Mode</button>
					</div>

                    </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
                       
           
                      <div class="row">   
                
                <div class="col-lg-12">
							<div id='calendar' style="padding-bottom:25px;"></div>
					   
                  
                </div>
                <!-- /.col-lg-6 -->
                
                
            </div>
            <!-- /.row -->
           
           
<script>

	$(document).ready(function() {
		
		
		
		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			//defaultDate: '2014-11-12',
			editable: false,
			allDaySlot: false,
			displayEventEnd:{
			    month: true,
			    basicWeek: true,
			    'default': true
			},
			timezone:"local",
			height: 600,
			slotDuration:'00:15:00',
			eventLimit: true, // allow "more" link when too many events
			events: [				
				<?php				
					if($data['events']) foreach($data['events'] as $ev) echo "{id:'".$ev['id']."',status:'".$ev['eventstatus']."',color:'".$data['evcolors'][$ev['activitytype']]."',title:'".$ev['subject']." - ( ".$ev['eventstatus']." ) Event: ".$ev['activitytype']."',start: '".$ev['date_start']."T".$ev['time_start']."+00:00',end: '".$ev['due_date']."T".$ev['time_end']."+00:00'},";
				?>
			
			],
			eventClick: function(calEvent, jsEvent, view) {
		
				window.location = 'index.php?module=Events&action=index&id='+calEvent.id;
		     
		
		    },
		    eventAfterRender : function(event,element,view){                           
                                       
								        var status = event.status;
								        var eventstart = new Date(event.start);
								        var today = new Date();
								        if(status === 'Held' || eventstart<today) {

							                target = element.find('.fc-time');
							                title = target.html();
							                titleStriked = title.strike();
							                target.html(titleStriked);
							                
							                if(element.find('.fc-title').length){
							                    title = event.title;
							                    titleStriked = title.strike();
							                    target = element.find('.fc-title');
							                    target.html(titleStriked);
							                }
							                
							            }
                                       
           },
		});
		
	});

</script>           
           
           
           
           
           
                
            
            
		</div>
        <!-- /#page-wrapper -->
    