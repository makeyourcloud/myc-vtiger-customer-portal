<?php

/* * *******************************************************************************
 * The content of this file is subject to the MYC Vtiger Customer Portal license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is Proseguo s.l. - MakeYourCloud
 * Portions created by Proseguo s.l. - MakeYourCloud are Copyright(C) Proseguo s.l. - MakeYourCloud
 * All Rights Reserved.
 * ****************************************************************************** */
?>
   </div>
    <!-- /#wrapper -->

</body>

<div class="modal fade" id="changePassModal" tabindex="-1" role="dialog" aria-labelledby="changePassModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="changePassModalLabel"><?php echo Language::translate("Change Password"); ?></h4>
      </div>
      <div class="modal-body">
      
      <?php 
      $msgt="none";
      if(isset($GLOBALS["opresult"]) && $GLOBALS["opresult"]!="") 
      {
      if($GLOBALS["opresult"]=="MSG_PASSWORD_CHANGED") $msgt="success";
      else $msgt="error";
      echo '<div class="alert alert-warning" role="alert">'.$GLOBALS["opresult"].'</div>'; 
      }
      ?>
      <?php if($msgt!="success"): ?>
        <form role="form" method="post">
		  <div class="form-group">
		    <label for="exampleInputPassword2">Old Password</label>
		    <input type="password" class="form-control" name="old_password" id="exampleInputPassword2" placeholder="Old Password">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">New Password</label>
		    <input type="password" class="form-control" name="new_password" id="exampleInputPassword1" placeholder="New Password">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword3">Confirm New Password</label>
		    <input type="password" class="form-control" name="confirm_password" id="exampleInputPassword3" placeholder="Confirm New Password">
		  </div>
		<input type="hidden" name="fun" value="changepassword">
		<?php endif; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <?php if($msgt!="success"): ?><input type="submit" class="btn btn-primary" value="Change Password"><?php endif; ?>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
                
function getFileNameOnly(filename) {
	var onlyfilename = filename;
  	// Normalize the path (to make sure we use the same path separator)
 	var filename_normalized = filename.replace(/\\\\/g, '/');
  	if(filename_normalized.lastIndexOf("/") != -1) {
    	onlyfilename = filename_normalized.substring(filename_normalized.lastIndexOf("/") + 1);
  	}
  	return onlyfilename;
}
/* Function to validate the filename */
function validateFilename(form_ele) {
if (form_ele.value == '') return true;
	var value = form_ele.files[0].name;
	
	
	
	// Color highlighting logic
	var err_bg_color = "#FFAA22";
	if (typeof(form_ele.bgcolor) == "undefined") {
		form_ele.bgcolor = form_ele.style.backgroundColor;
	}
	// Validation starts here
	var valid = true;
	/* Filename length is constrained to 255 at database level */
	if (value.length > 255) {
		alert(alert_arr.LBL_FILENAME_LENGTH_EXCEED_ERR);
		valid = false;
	}
	if (!valid) {
		form_ele.style.backgroundColor = err_bg_color;
		return false;
	}
	form_ele.style.backgroundColor = form_ele.bgcolor;
	form_ele.form[form_ele.name + '_hidden'].value = value;
	return true;
}

$(function(){
	$(".chosen-select").chosen({disable_search_threshold: 10});
	

	$('#dataTables-example').dataTable().fnSort( [[0,"desc"]]);
	$('#dataTables-example').DataTable().page.len(50).draw();

})


</script>

</html>
