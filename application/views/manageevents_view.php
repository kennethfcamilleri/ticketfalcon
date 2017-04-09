<div class="col-md-8 col-md-offset-2">

	<h3>Manage Events</h3>

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
       
    <?php if (count($events_summary) > 0): ?>

    	<div class="list-group">
	      <?php foreach ($events_summary as $event): ?>

	      <?php $event_url = base_url() . "events/show/".$event->event_id."/"; ?>

	      <div class="list-group-item">
	        <h4 class="text-primary"><?php echo $event->event_name; ?></h4>
	        <p><?php echo date('l jS \of F Y h:i A',strtotime($event->start_date)); ?></p>
	        <p>Total Tickets: <strong><?php echo $event->quantity_available; ?></strong></p>
	        <p>Tickets Sold: <strong><?php echo $event->tickets_sold; ?></strong></p>
	        <p>
	        	<a href="<?php echo base_url();?>events/manage/<?php echo $event->event_id; ?>"><span class="glyphicon glyphicon-cog"></span> Manage</a>&nbsp;&nbsp;
	        	<a href="<?php echo base_url();?>events/show/<?php echo $event->event_id; ?>"><span class="glyphicon glyphicon-eye-open"></span> View</a>&nbsp;&nbsp;
	        	<a href="<?php echo base_url();?>events/delete/<?php echo $event->event_id; ?>"><span class="glyphicon glyphicon-trash"></span> Delete</a>
	        </p>
	      </div>
	      <br>

	      <?php endforeach; ?>

	    </div>

    <?php else: ?>

        <p>You currently have no events set.</p>

    <?php endif; ?>

    <br>

</div>