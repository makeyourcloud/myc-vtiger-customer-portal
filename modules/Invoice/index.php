<?php
/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */

class Invoice extends BaseModule{


function detail($targetid){	
	
	$this->targetid=$targetid;
	
	$sparams = array(
		'id' => "$targetid", 
		'block'=>$this->module,
		'contactid'=>$_SESSION["loggeduser"]['id'],
		'sessionid'=>$_SESSION["loggeduser"]['sessionid']
	);
		
	$lmod = $GLOBALS["sclient"]->call('get_invoice_detail', $sparams);
	
	
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
	$data['targetid']=$targetid;
		
	
	Template::display($this->module,$data,'detail');

}

}

?>