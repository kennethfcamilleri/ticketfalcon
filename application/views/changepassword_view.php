<div class="col-md-8 col-md-offset-2">

<h3>Account Settings</h3>

<br>

<ul class="nav nav-tabs">
  <li><a href="<?php echo base_url();?>users/contactinfo/">Contact Info</a></li>
  <li class="active"><a href="<?php echo base_url();?>users/changepassword/">Change Password</a></li>
</ul>


  <div id="changepassword" class="tab-pane fade in active">

		<form id="changepassword_form" class="col-sm-12" action="<?php echo base_url();?>users/update_password/" method="post">

		  <br>

	      <h4>Change Password</h4>

			<br>

			<?php if($this->session->flashdata('success')): ?>

			<div class="alert alert-success alert-dismissable">
			  	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  	<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
			</div>

			<?php elseif($this->session->flashdata('error')): ?>

			<div class="alert alert-danger alert-dismissable">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			  	<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
			</div>

			<?php endif; ?>

		  <div class="form-group">
		    <label for="currentpassword">Current Password:</label>
		    <div>
		      <input type="password" class="form-control" name="currentpassword" placeholder="Current Password" required>
		    </div>
		  </div>
		   <div class="form-group">
		    <label for="newpassword">New Password:</label>
		    <div>
		      <input type="password" class="form-control" name="newpassword" placeholder="New Password" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="confirmpassword">Confirm Password:</label>
		    <div>
		      <input type="password" class="form-control" name="confirmpassword" placeholder="Confirm Password" required>
		    </div>
		  </div>
		  <br>
		  <div class="form-group">
		    <div>
		      <button type="submit" class="btn btn-success">Save Password</button>
		    </div>
		  </div>
		  <br>
		</form>
  </div>

 </div>