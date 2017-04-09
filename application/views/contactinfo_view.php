<div class="col-md-8 col-md-offset-2">

<h3>Account Settings</h3>

<br>

<ul class="nav nav-tabs">
  <li class="active"><a href="<?php echo base_url();?>users/contactinfo/">Contact Info</a></li>
  <li><a href="<?php echo base_url();?>users/changepassword/">Change Password</a></li>
</ul>

<div class="tab-content">
  <div id="contactinfo" class="tab-pane fade in active">

		<form id="contactinfo_form" class="col-sm-12" action="<?php echo base_url();?>users/update_contact_info/" method="post">

		  <br>

		  <h4>Contact Info</h4>

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
		    <label for="firstname">First Name:</label>
		    <div>
		      <input type="text" class="form-control" name="firstname" value="<?php echo $user_details->first_name; ?>" required>
		    </div>
		  </div>
		   <div class="form-group">
		    <label for="lastname">Last Name:</label>
		    <div>
		      <input type="text" class="form-control" name="lastname" value="<?php echo $user_details->last_name; ?>" required>
		    </div>
		  </div>
		  <div class="form-group">
		    <label for="email">Email:</label>
		    <div>
		      <input type="email" class="form-control" name="email" value="<?php echo $user_details->email_address; ?>" required>
		    </div>
		  </div>
		  <br>
		  <div class="form-group">
		    <div>
		      <button type="submit" class="btn btn-success">Save Changes</button>
		    </div>
		    <br>
		  </div>
		</form>
  </div>
</div>

</div>