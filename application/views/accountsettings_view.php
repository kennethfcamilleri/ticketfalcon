<div class="col-md-8 col-md-offset-2">

<h3>Account Settings</h3>

<br>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#contactinfo">Contact Info</a></li>
  <li><a data-toggle="tab" href="#changepassword">Change Password</a></li>
</ul>

<div class="tab-content">
  <div id="contactinfo" class="tab-pane fade in active">

		<form id="contactinfo_form" class="col-sm-12" action="update" method="post">

		  <br>

		  <h4>Contact Info</h4>

			<p class="text-success">

			<?php 

		  	// If changes saved successfully

			if($this->session->flashdata('user_updated')) {
				echo $this->session->flashdata('user_updated');
			}

			?>

			</p>

			<br>

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

  <div id="changepassword" class="tab-pane fade">

		<form id="checkout_form" class="col-sm-12" action="changepassword" method="post">

		  <br>

	      <h4>Change Password</h4>

			<p class="text-success">

			<?php 

		  	// If password updated successfully

			if($this->session->flashdata('password_updated')) {
				echo $this->session->flashdata('password_updated');
			}

			?>

			</p>

			<p class="text-danger">

			<?php 

		  	// If password was not updated

			if($this->session->flashdata('password_error')) {
				echo $this->session->flashdata('password_error');
			}

			if($this->session->flashdata('errors')) {
				echo $this->session->flashdata('errors');
			}

			?>

			</p>

			<br>

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

</div>

<script>
    $(function () {
        var hash = window.location.hash;
        hash && $('ul.nav a[href="' + hash + '"]').tab('show');
    });
</script>