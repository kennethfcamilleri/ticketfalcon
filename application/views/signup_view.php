<div class="col-md-8 col-md-offset-2">

<h2>Sign Up</h2>

<?php $attr = array('id' => 'signup_form', 'class' => 'form_horizontal'); ?>

<?php 
	
	if($this->session->flashdata('errors')) {
		echo $this->session->flashdata('errors');
	}

?>

<?php echo form_open('users/signup',$attr); ?>

<div class="form-group">

	<?php echo form_label('First Name:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'firstname',
		'placeholder' => 'Your first name'
		);
	?>

	<?php echo form_input($data); ?>

</div>


<div class="form-group">

	<?php echo form_label('Last Name:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'lastname',
		'placeholder' => 'Your last name'
		);
	?>

	<?php echo form_input($data); ?>

</div>


<div class="form-group">

	<?php echo form_label('Email:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'email',
		'placeholder' => 'Your email address'
		);
	?>

	<?php echo form_input($data); ?>

</div>

<div class="form-group">

	<?php echo form_label('Password:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'password',
		'placeholder' => 'Your password'
		);
	?>

	<?php echo form_password($data); ?>
	
</div>

<div class="form-group">

	<?php echo form_label('Confirm Password:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'confirmpassword',
		'placeholder' => 'Re-enter password'
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