<!DOCTYPE html>
<html lang="en">
<head>
  <title>Ticket Falcon</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- 
    To be retrieved from local folder instead
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  -->


  <!-- Import bower components for data picker functionality -->
  <script type="text/javascript" src="<?php echo base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/bower_components/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo base_url();?>assets/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/mystylesheet.css">

</head>
<body>

<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Ticket Falcon</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="<?php echo base_url(); ?>">Home</a></li>
    </ul>

    <form class="navbar-form navbar-left" role="search" action="<?php echo base_url();?>events/search" method="post">
      <div class="form-group input-group">
        <input type="text" class="form-control" placeholder="Search Events.." name="search">
        <span class="input-group-btn">
          <button class="btn btn-default" type="submit">
            <span class="glyphicon glyphicon-search"></span>
          </button>
        </span>        
      </div>
    </form>

    <?php if ($this->session->userdata('logged_in')): ?>

    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo $this->session->userdata('fullname'); ?> <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo base_url();?>events/addevent_form/">Create Event</a></li>
          <li><a href="<?php echo base_url();?>events/manage_events/">Manage Events</a></li>
          <li><a href="<?php echo base_url();?>users/bookinghistory">Booking History</a></li>
          <li><a href="<?php echo base_url();?>users/contactinfo/">Account Settings</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="<?php echo base_url();?>users/login_form">Log Out</a></li>
        </ul>
      </li>
    </ul>

    <?php else: ?>

	  <ul class="nav navbar-nav navbar-right">
      <li><a href="<?php echo base_url();?>users/signup_form"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="<?php echo base_url();?>users/login_form"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
	    <li><a href="<?php echo base_url();?>events/addevent_form"><span class="glyphicon glyphicon-plus"></span> Create Event</a></li>
    </ul>

    <?php endif; ?>

  </div>
</nav>

<div class="jumbotron">
  <div class="container text-center">
    <h2>Welcome to Ticket Falcon</h2>
    <p>Your online event ticketing solution</p>

    <a href="<?php echo base_url();?>events/addevent_form" class="btn btn-md btn-success" role="button">Create your event</a>

  </div>
</div>

  
<div class="container">
        
    <?php $this->load->view($main_view); ?>

<!--     <div class="col-md-6 col-md-offset-3">
        
    </div> -->

<!--     <div class="col-xs-4 col-xs-offset-4">
       <?php //$this->load->view('login_view'); ?>
    </div> -->
</div>

<footer class="footer text-center">
  <div class="container">
    <p class="text-muted">&copy; 2017 Ticket Falcon</p>
  </div>
</footer>

</body>
</html>