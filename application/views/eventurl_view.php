<div class="col-md-8 col-md-offset-2">

	<h3>Event URL</h3>

	<br>

	<ul class="nav nav-tabs">
	  <li><a href="<?php echo base_url();?>events/manage/<?php echo $event_id; ?>">General</a></li>
	  <li><a href="<?php echo base_url();?>events/event_tickets/<?php echo $event_id; ?>">Tickets</a></li>
	  <li><a href="<?php echo base_url();?>events/event_bookings/<?php echo $event_id; ?>">Bookings</a></li>
	  <li class="active"><a href="<?php echo base_url();?>events/event_url/<?php echo $event_id; ?>">Event URL</a></li>
	</ul>

	<div class="tab-content">

	    <div id="eventurl" class="tab-pane fade in active">

			<br><br>

			<div class="form-group">
				
				<label for="eventurl">Event URL:</label><br><br>
				
				<div>
					<input type="text" class="form-control" id="eventurl-inputbox" value="<?php echo $event_url; ?>" readonly>
				</div>
			
			</div>

	  	</div>

	</div>

</div>