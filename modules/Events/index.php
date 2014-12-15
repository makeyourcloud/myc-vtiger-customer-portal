<?php
/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */

class Events {

	var $module;
	var $targetid;
	
	/*****************************************************************************
	* Function: BaseModule::__construct()
	* ****************************************************************************/

	public function __construct($module=false,$targetid=false){
		
		if(!$module) $this->module=get_class($this);
		else $this->module=$module;
		
	}
	
	function get_list(){	
				
		
		$query = "SELECT * FROM ".$this->module; 
			if(isset($GLOBALS['api_modules'][$this->module]['relation_fields'])){
				$query.=" WHERE ";
				$firstcond=true;
				foreach($GLOBALS['api_modules'][$this->module]['relation_fields'] as $relfield){
					if(!$firstcond) $query.=" OR ";
					if($relfield=="contact_id") $query.=$relfield."=".Api::getModuleId("Contacts")."x".$_SESSION["loggeduser"]['id'];
					else $query.=$relfield."=".Api::getModuleId("Accounts")."x".$_SESSION["loggeduser"]['accountid'];
					
					$firstcond=false;
				}
			} 
		
		if($GLOBALS['api_client']!="NOT_CONFIGURED" && $GLOBALS['api_client']!="NOT_CONFIGURED"){
			$records = $GLOBALS['api_client']->doQuery($query);
		}
		else $records = array();
	    
	    $evcolors=array();
	    $palette=array("orange","red","green","black","purple","grey","blue");
	    
	    if($records) {
	        foreach($records as $record) {           
	            if(!isset($evcolors[$record['activitytype']])) 
	            	$evcolors[$record['activitytype']]=$palette[count($evcolors)];
	        }
		}
		
		
		$data['evcolors']=$evcolors;
		$data['events']=$records;		
		$data['events_columns'] = $GLOBALS['api_modules'][$this->module]['list_fields'];
		
		$displaymode="calendar";	
		if(isset($_REQUEST['list_mode'])) $displaymode="list";	
		Template::display($this->module,$data,$displaymode);
	
	}
	
	function detail($targetid){	
								
		$query = "SELECT * FROM Events WHERE id='".$targetid."' AND contact_id=18x".$_SESSION["loggeduser"]['id']; 
		
		if($GLOBALS['api_client']!="NOT_CONFIGURED" && $GLOBALS['api_client']!="NOT_CONFIGURED"){
			$records = $GLOBALS['api_client']->doQuery($query);
		}
		else $records = array();
	    
	    
		$data['event']=$records[0];		
		$data['events_columns'] = $GLOBALS['api_modules'][$this->module]['detail_fields'];
		
		Template::display($this->module,$data,"detail");
		
	}

}

?>