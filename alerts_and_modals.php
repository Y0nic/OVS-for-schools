<!--action alert-->
<div id="action_alert" class="alert py-1 w-100 fixed none" role="alert">
	<i class="fas ms-1" aria-hidden="true"></i>
	<span class="alert-content"></span>
</div>
<!--action alert-->

<!--alert modal-->
<div class="modal fade" id="alert_modal" aria-hidden="true" aria-labelledby="label" tabindex="-1">

	<div class="modal-dialog modal-dialog-centered">
	
		<div class="modal-content">
		
			<div class="modal-header">
			
				<h5 class="modal-title" id="label"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				
			</div>
			
			<div class="modal-body">
        
			</div>
			
			<div class="modal-footer">
			
				<button type="button" class="btn" id="sure" data-voting_id="<?php echo $id;?>" data-bs-dismiss="modal">Sure</button>
				
			</div>
			
		</div>
		
	</div>
	
</div>
<!--alert modal-->


<?php

	//Alert and Modals for Voting List
	if(strtolower($_SERVER['SCRIPT_NAME']) === "/voting_platform/voting_management.php"){

?>

<!--Edit Candidate-->
<div class="modal fade" id="edit_candidate_modal" aria-hidden="true" aria-labelledby="label" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label">Edit Candidate</h5>
      </div>
      <div class="modal-body">
		
			<div class="mb-3">
				<label class="form-label h6">Firstname</label>
				<input type="text" name="first_name" class="form-control first_name" value="">
			</div>
			
			<div class="mb-3">
				<label class="form-label h6">Lastname</label>
				<input type="text" name="last_name" class="form-control last_name" value="">
			</div>
			
			<div id="edit_candidate_category_reloader">
			<div class="mb-3">
				<label class="form-label h6">Category</label>
				<select name="category_id"  class="form-control category">
					
					<?php 
					
						$edit_can_categories_qry = mysqli_query($con,"SELECT * FROM `category` WHERE voting_id = '$id' order by id") or die(mysqli_error($con));
					
						while($cat = mysqli_fetch_array($edit_can_categories_qry)){
						
					?>
					
					<option id="<?php echo $cat["id"];?>" value="<?php echo $cat["id"];?>"><?php echo $cat["category"];?></option>
					
					<?php
					
						};
					
					?>
					
				</select>
			</div>
			</div>
			
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="save_candidate" class="btn btn-primary" data-bs-dismiss="modal">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<!--Edit Candidate-->

<!--edit category-->
<div class="modal fade" id="edit_category_modal" aria-hidden="true" aria-labelledby="label" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div  class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label">Edit Category</h5>
      </div>
      <div class="modal-body">

			<div class="mb-3">
				<label class="form-label h6">Category</label>
				<input type="text" name="category" class="form-control category" value="">
			</div>
		
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="save_category" class="btn btn-primary" data-bs-dismiss="modal">Save Changes</button>
      </div>
    </div>
  </div>
</div>
<!--edit category-->

<!--add category-->
<div class="modal fade" id="add_category_modal" aria-hidden="true" aria-labelledby="label" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label">Add Category</h5>
      </div>
      <div class="modal-body">

			<div class="mb-3">
				<label class="form-label h6">Category</label>
				<input id="category" type="text" class="form-control" value="">
				<p class="text-danger none">Please enter category</p>
			</div>
		
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="add_category" data-voting_id="<?php echo $_GET["id"];?>" class="btn btn-primary disabled" data-bs-dismiss="">Add Category</button>
      </div>
    </div>
  </div>
</div>
<!--add category-->

<!--add candidate-->
<div class="modal fade" id="add_candidate_modal" aria-hidden="true" aria-labelledby="label" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div method="post" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="label">Add Candidate</h5>
      </div>
      <div class="modal-body">

			<div class="mb-3">
				<label class="form-label h6">Firstname</label>
				<p class="text-danger h6"></p>
				<input type="text" class="form-control first_name" value="">
			</div>
			
			<div class="mb-3">
				<label class="form-label h6">Lastname</label>
				<p class="text-danger h6"></p>
				<input type="text" class="form-control last_name" value="">
			</div>
			
			<div id="add_candidate_category_reloader">
			<div class="mb-3">
				<label class="h6">Category</label>
				<select class="form-select form-select-sm category">
				
					<?php 
					
						$categories_qry = mysqli_query($con,"SELECT * FROM `category` WHERE voting_id = '$id' order by id") or die(mysqli_error($con));
					
						while($categories = mysqli_fetch_array($categories_qry)){
						
					?>
					
				  <option value="<?php echo $categories["id"];?>"><?php echo $categories["category"];?></option>
				  
					<?php 
					
						};
						
						
					?>
				  
				</select>
			</div>
			</div>

      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="add_candidate" data-voting_id="<?php echo $_GET["id"];?>" class="btn btn-primary" data-bs-dismiss="modal">Add Candidate</button>
      </div>
    </div>
  </div>
</div>
<!--add candidate-->

<?php };?>

<?php 
	
	//Alert and Modals for Users Page
	
	if(strtolower($_SERVER['SCRIPT_NAME']) === "/voting_platform/users.php"){

?>

<!--  Edit User Modal -->
<div class="modal fade" id="edit_user_modal" aria-hidden="true" aria-labelledby="label" tabindex="-1">

	<div class="modal-dialog modal-dialog-centered">
	
		<form method="post" class="modal-content">
		
			<div class="modal-header">
			
				<h5 class="modal-title" id="label">Edit User</h5>
				
			</div>
			
			<div class="modal-body">

				<div class="mb-3">
				
					<label class="form-label h6">Firstname</label>
					<p class="text-danger h6 validate_first_name"></p>
					<input type="text" name="first_name" class="form-control first_name" value="">
					<input type="hidden" name="id" class="form-control id" value="">
					
				</div>
				
				<div class="mb-3">
				
					<label class="form-label h6">Lastname</label>
					<p class="text-danger h6 validate_last_name"></p>
					<input type="text" name="last_name" class="form-control last_name" value="">
					
				</div>
				
				<div class="mb-3 lrn">
				
					<label class="form-label h6">LRN</label>
					<p class="text-danger h6 validate_lrn"></p>
					<input type="text" name="LRN" class="form-control edit_lrn" value="">
					
				</div>
					
				<div class="mb-3 none">
				
					<label class="form-label h6">Password</label>
					<p class="text-danger h6 validate_pass"></p>
					<input type="text" name="password" class="form-control password" value="">
					
				</div>
				
				<div class="mb-3">
				
					<label class="h6">Access</label>
					<select class="form-select form-select-sm" id="edit_access" name="access">
					
					  <option id="user" value="user">User</option>
					  <option id="admin" value="admin">Admin</option>
					  
					</select>
					
				</div>	

			</div>
			
			<div class="modal-footer">
			
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<input type="submit" name="save" class="btn btn-primary save disabled" value="Save Changes">
				
			</div>
			
		</form>
		
	</div>
	
</div>
<!--  Edit User Modal -->

<?php };?>