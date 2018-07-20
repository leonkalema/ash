<?php
/*
#Author: MOVER
12/11/14
10:21 PM
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$project = "";
$users = "";
$pid = "";
if(!empty($projectdata))
{
	foreach($projectdata as $row)
	{
		$project = $row['title'];
		$pid = $row['id'];
	}
}


?>

<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<form role="form" name="pmanage" class="pmanage" action="<?=base_url().$this->uri->segment(1).'/'.$this->uri->segment(2)?>/project_managers">
				<div class="form-group">
					 <label for="exampleInputEmail1">Add Users</label>
                     
                  <select id="user" name="usrt" class="form-control " tabindex="-1">
                  <?php
				//print_r($userss);
				  if(!empty($userss))
				  {
					  foreach($userss as $row)
					  {
						  $fname = $row['fname'];
						  $lname = $row['lname'];
						  if($fname != '' && $lname !='')
						  {
							  $avatar  = $fname.'&nbsp;'.$lname; 
						  }
						  else
						  {
						  $avatar =  $tel = $row['tel'];;
						  }
						  ?>
                          <option value="<?=$row['id']; ?>"><?=$avatar; ?></option>
                          <?php
					  }
					  
				  }
				  else
				  {
					  ?>
                      <option>No Users </option>
                      <?php
				  }
				  ?>
                     </select>
                     
                    <!-- <input type="text" required="required" class="form-control" id="e23" /> -->
				</div>
				<div class="form-group">
					 <label for="exampleInputPassword1">Project</label><input readonly="readonly" type="text" class="form-control" id="projectname" value="<?=$project ?>" />
				</div>
				
				<div class="hidden">
					<input file="hidden" name="pid" id="pid" value="<?=$pid; ?>" />
                  
				</div> 
                <div class="modal-footer">
							 <button type="button" class="btn btn-default " data-dismiss="modal">Close</button> <button type="button" class="btn btn-primary assign" onclick="javascdript:save_projectm();">Assign </button>
						</div>
			</form>
		</div>
	</div>
</div>