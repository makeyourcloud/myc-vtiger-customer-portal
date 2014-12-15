<?php
/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */



class BaseModule{

	var $module;
	var $targetid;
	
	/*****************************************************************************
	* Function: BaseModule::__construct()
	* ****************************************************************************/

	public function __construct($module=false,$targetid=false){
		
		if(!$module) $this->module=get_class($this);
		else $this->module=$module;
		
	}


	/*****************************************************************************
	* Function: BaseModule::get_list()
	* ****************************************************************************/
		
	public function get_list() 
    {
    	if(!isset($GLOBALS['api_modules'][$this->module])){
	    
	    	$allow_all = $GLOBALS["sclient"]->call('show_all',array('module'=>$this->module));
		
			if($allow_all!='true') $onlymine="true";
			
			$sparams = array(
				'id' => $_SESSION["loggeduser"]['id'], 
				'block'=>$this->module,
				'sessionid'=>$_SESSION["loggeduser"]['sessionid'],
				'onlymine'=>$onlymine
			);
			
			$lmod = $GLOBALS["sclient"]->call('get_list_values', $sparams);
		
			if(isset($lmod) && count($lmod)>0 && $lmod!=""){
				$data['recordlist']=$lmod[1][$this->module]['data'];
				$data['tableheader']=$lmod[0][$this->module]['head'][0];
				$data['summaryinfo']=$this->dashboard();
			}		
			
			Template::display($this->module,$data,'list');
		
		}
		
		else {
			$query = "SELECT * FROM ".$GLOBALS['api_modules'][$this->module]['modulename']; 
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
				$data['records'] = $GLOBALS['api_client']->doQuery($query);
			}
			else $data['records'] = array();
					
			$data['records_columns'] = $GLOBALS['api_modules'][$this->module]['list_fields'];

			Template::display($this->module,$data,"list_api");
		}
	
	}


	/*****************************************************************************
	* Function: BaseModule::detail()
	* ****************************************************************************/
		
	public function detail($targetid,$display=true) 
    {
    	$this->targetid = $targetid;
    	 
    	if(!isset($GLOBALS['api_modules'][$this->module])){
    	   	
		$sparams = array(
			'id' => $this->targetid, 
			'block'=>$this->module,
			'contactid'=>$_SESSION["loggeduser"]['id'],
			'sessionid'=>$_SESSION["loggeduser"]['sessionid']
		);
			
			
		$lmod = $GLOBALS["sclient"]->call('get_details', $sparams);
	
			
		foreach($lmod[0][$this->module] as $ticketfield) {	
			$fieldlabel = $ticketfield['fieldlabel'];
			$fieldvalue = $ticketfield['fieldvalue'];
			$blockname = $ticketfield['blockname'];
					
			if(!isset($mod_infos[$blockname])) $mod_infos[$blockname]=array();
			$mod_infos[$blockname][]=array("label"=>$fieldlabel,"value"=>$fieldvalue);				
		}
		
		$docs=$this->get_documents();
		if(isset($docs) && count($docs)>0) $mod_infos=array_merge($mod_infos, $docs);
		
		$data['recordinfo']=$mod_infos;
		if($display) Template::display($this->module,$data,'detail');
		else return $mod_infos;	
		
		}
		
		else {
		
			$query = "SELECT * FROM ".$GLOBALS['api_modules'][$this->module]['modulename']; 
			if(isset($GLOBALS['api_modules'][$this->module]['relation_fields'])){
				$query.=" WHERE ";
				$firstcond=true;
				foreach($GLOBALS['api_modules'][$this->module]['relation_fields'] as $relfield){
					if(!$firstcond) $query.=" OR ";
					if($relfield=="contact_id") $query.=$relfield."=".Api::getModuleId("Contacts")."x".$_SESSION["loggeduser"]['id'];
					else $query.=$relfield."=".Api::getModuleId("Accounts")."x".$_SESSION["loggeduser"]['accountid'];
					
					$firstcond=false;
				}
				$query.=" AND id=".$this->targetid;
			}
			else $query.=" WHERE id=".$this->targetid;
			
			
			if(isset($GLOBALS['api_client']) && $GLOBALS['api_client']!="NOT_CONFIGURED" && $GLOBALS['api_client']!="API_LOGIN_FAILED"){
			  	$apidata = $GLOBALS['api_client']->doQuery($query);
				$data['record']=$apidata[0];
			}
			else $data['record'] = array();
					
			$data['records_columns'] = $GLOBALS['api_modules'][$this->module]['detail_fields'];

			Template::display($this->module,$data,"detail_api");
			
		}				
		
	}

	
	/*****************************************************************************
	* Function: BaseModule::get_documents()
	* ****************************************************************************/
		
	public function get_documents(){
		
		$params = Array(
			'id' => $this->targetid ,
			'module' => "Documents",
			'contactid' => $_SESSION["loggeduser"]['id'], 
			'sessionid'=>$_SESSION["loggeduser"]['sessionid']
		);
		
		$resultb = $GLOBALS["sclient"]->call('get_documents', $params);
			
		if(isset($resultb) && count($resultb)>0 && $resultb!=""){
			$ca=0;
			foreach($resultb[1]['Documents']['data'] as $doc){ 
				$mod_infos["Attachments"][$ca]['label']="File"; 
				$mod_infos["Attachments"][$ca]['value']=$doc[1]['fielddata']; 
				$ca++;
			}
		}
		
		return $mod_infos;
		
	}
	
	
			
	public function dashboard() 
    {
    
    	$mod_stats_values=array(
    		"Quotes" => array("Accepted","Created","Delivered"),
    		"Project" => array("in progress","completed","on hold","prospecting"),
    		"HelpDesk" => array("Wait For Response","Open","In Progress","Closed"),
    		"Invoice" => array("AutoCreated","Created","Approved","Sent","Paid","Cancel","Credit Invoice"),
    		"Documents" => array(),
    	);	
    		
		if($this->module!='Home') {
		
			if(isset($mod_stats_values[$this->module])) {
				$mod_stats_values=array($this->module => $mod_stats_values[$this->module]);
			}
			else return false;
		}
		
		foreach($mod_stats_values as $modname => $modfields){
		
			if(in_array($modname, $GLOBALS['avmod'])){
				
				$sparams = array(
					'id' => $_SESSION["loggeduser"]['id'], 
					'block'=>$modname,
					'sessionid'=>$_SESSION["loggeduser"]['sessionid'],
					'user_name' => $_SESSION["loggeduser"]['user_name'],
				);
								
				if($modname=="HelpDesk") $moddata = $GLOBALS["sclient"]->call('get_tickets_list', array($sparams)); 
				else $moddata = $GLOBALS["sclient"]->call('get_list_values', $sparams);
				
				$rc=0;
				
				if(isset($moddata) && count($moddata)>0 && $moddata!="")
				{
					$data[$modname]['count']=0;
					
					if($modname=="HelpDesk") {
						$mdata=$moddata[1]['data'];
						$mhead=$moddata[0]['head'][0];
					}
					else {
						$mdata=$moddata[1][$modname]['data'];
						$mhead=$moddata[0][$modname]['head'][0];
					}
					
					
					foreach($mdata as $record){
						
						$fc=0;				
						
						foreach($mhead as $fieldname){
							
							$fielddata=$record[$fc]['fielddata'];
							
							if(in_array($fielddata, $modfields)){
								if(!isset($data[$modname][$record[$fc]['fielddata']])) $data[$modname][$record[$fc]['fielddata']]=0;
								$data[$modname][$record[$fc]['fielddata']]++;
							}
																						
							
							$fc++;
						}
						
						$data[$modname]['count']++;
						
						$rc++;
					}
				}
						
			}
		
		}
		
		
		if($this->module!='Home') {
			return $data;		
		}		
		
		else Template::display($this->module,$data,'dashboard');
	}

	
}
