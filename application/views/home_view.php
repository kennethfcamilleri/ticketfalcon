
<p class="bg-success">

<?php 

	// if login is successfull

	if($this->session->flashdata('login_success')) {
		echo $this->session->flashdata('login_success');
	}

	// if sign-up is successfull

	if($this->session->flashdata('registered')) {
		echo $this->session->flashdata('registered');
	}


	// if event is created

	if($this->session->flashdata('event_created')) {
		echo $this->session->flashdata('event_created');
	}

?>

</p>


<p class="bg-danger">

<?php 

	// if login has failed..

	if($this->session->flashdata('login_failed')) {
		echo $this->session->flashdata('login_failed');
	}

?>

</p>

<div class="col-md-10 col-md-offset-1">

  <div class="text-left">
    <h3>Recently Added Events</h3><br>
  </div>

  <?php if (count($recent_events) > 0): ?>

  <div class="row">

  <?php foreach ($recent_events as $event): ?>

  <?php $event_url = base_url() . "events/show/".$event->event_id."/"; ?>
  
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5 class="text-primary"><?php echo $event->event_name; ?></h5>
        </div>
        <div class="panel-body">
          <p><span class="glyphicon glyphicon-time"></span> <?php echo date('l jS F Y h:i A',strtotime($event->start_date)); ?></p>
          <p><span class="glyphicon glyphicon-map-marker"></span> <?php echo $event->event_location; ?></p>
        </div>
        <div class="panel-footer text-center">
          <a href="<?php echo $event_url ?>" class="btn btn-md btn-primary" role="button">Get Tickets</a>
        </div>
      </div> 
    </div>

  <?php endforeach; ?>

  </div>

  <?php else: ?>

      <p>There are currently no events listed at the moment.</p>

  <?php endif; ?>
<!-- 
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5 class="text-primary">Rhythm District pres. DOSEM</h5>
        </div>
        <div class="panel-body">
          <p><span class="glyphicon glyphicon-time"></span> Tuesday March 21 2017 5:30 PM</p>
          <p><span class="glyphicon glyphicon-map-marker"></span> The Playground, Malta.</p>
        </div>
        <div class="panel-footer text-center">
          <button class="btn btn-primary btn-md">Get Tickets</button>
        </div>
      </div> 
    </div> 

     <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h5 class="text-primary">Rhythm District pres. DOSEM</h5>
        </div>
        <div class="panel-body">
          <p><span class="glyphicon glyphicon-time"></span> Tuesday March 21 2017 5:30 PM</p>
          <p><span class="glyphicon glyphicon-map-marker"></span> The Playground, Malta.</p>
        </div>

        <div class="panel-footer text-center">
          <button class="btn btn-primary btn-md">Get Tickets</button>
        </div>
      </div> 
    </div> -->
  <br>
</div>

