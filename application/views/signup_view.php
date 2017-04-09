<div class="col-md-8 col-md-offset-2">

<h2>Sign Up</h2>

<?php $attr = array('id' => 'signup_form', 'class' => 'form_horizontal'); ?>

<?php if($this->session->flashdata('error')): ?>

<div class="alert alert-danger alert-dismissable">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  	<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>

<?php endif; ?>

<?php echo form_open('users/signup',$attr); ?>

<div class="form-group">

	<?php echo form_label('First Name:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'firstname',
		'placeholder' => 'Your first name',
		'value' => set_value('firstname'),
		'required' => 'required'
		);
	?>

	<?php echo form_input($data); ?>

</div>


<div class="form-group">

	<?php echo form_label('Last Name:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'lastname',
		'placeholder' => 'Your last name',
		'value' => set_value('lastname'),
		'required' => 'required'
		);
	?>

	<?php echo form_input($data); ?>

</div>


<div class="form-group">

	<?php echo form_label('Email:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'email',
		'placeholder' => 'Your email address',
		'value' => set_value('email'),
		'type' => 'email',
		'required' => 'required'
		);
	?>

	<?php echo form_input($data); ?>

</div>

<div class="form-group">

	<?php echo form_label('Password:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'password',
		'placeholder' => 'Your password',
		'required' => 'required'
		);
	?>

	<?php echo form_password($data); ?>
	
</div>

<div class="form-group">

	<?php echo form_label('Confirm Password:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'confirmpassword',
		'placeholder' => 'Re-enter password',
		'required' => 'required'
		);
	?>

	<?php echo form_password($data); ?>
	
</div>

<div class="form-group">

	<?php $data = array(
		'class' => 'btn btn-primary',
		'name' => 'submit',
		'value' => 'Sign Up'
		);
	?>

	<?php echo form_submit($data); ?>
	
</div>

<?php echo form_close(); ?>

<br>

</div>