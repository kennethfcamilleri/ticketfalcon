<div class="col-md-8 col-md-offset-2">

<?php if ($this->session->userdata('logged_in')): ?>

<h2>Logout</h2>

<?php echo form_open('users/logout'); ?>

<p>

<?php 
	if ($this->session->userdata('username')) {
		echo "You are logged in as: " . $this->session->userdata('username');
	}
?>

</p>

<?php
	
	$data = array(
		'class' => 'btn btn-primary',
		'name' => 'submit',
		'value' => 'Logout'
		);
?>

<?php echo form_submit($data); ?>

<?php echo form_close(); ?>

<?php else: ?>

<h2>Login</h2>

<?php $attr = array('id' => 'login_form', 'class' => 'form_horizontal'); ?>

<?php 
	
	if($this->session->flashdata('errors')) {
		echo $this->session->flashdata('errors');
	}

?>

<?php echo form_open('users/login',$attr); ?>

<div class="form-group">

	<?php echo form_label('Username:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'username',
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

	<?php $data = array(
		'class' => 'btn btn-primary',
		'name' => 'submit',
		'value' => 'Login'
		);
	?>

	<?php echo form_submit($data); ?>
	
</div>

<?php echo form_close(); ?>

<?php endif; ?>

</div>