<?php return array (

"Events" => array(
	"modulename"=>"Events",
	"relation_fields"=>array("contact_id"),
	"link_field"=>"subject",
	"list_fields"=>array("subject","date_start","time_start","due_date","time_end","eventstatus","activitytype","location"),
),
/*
"Sales Order" => array(
	"modulename"=>"SalesOrder",
	"relation_fields"=>array("account_id","contact_id"),
	"list_fields"=>array("subject"),
	"link_field"=>"subject",
	"detail_fields"=>array(
		"SALESORDER_BLOCK1"=>array("subject","customerno"),
		"SALESORDER_BLOCK2"=>array("customerno","sostatus","salesorderno"),
	),		
),
*/
); ?>