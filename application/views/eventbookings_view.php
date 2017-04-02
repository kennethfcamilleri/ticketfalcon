<div class="col-md-8 col-md-offset-2">

	<h3>Event Bookings</h3>

	<br>

	<ul class="nav nav-tabs">
	  <li><a href="<?php echo base_url();?>events/manage/<?php echo $event_id; ?>">General</a></li>
	  <li><a href="<?php echo base_url();?>events/event_tickets/<?php echo $event_id; ?>">Tickets</a></li>
	  <li class="active"><a href="<?php echo base_url();?>events/event_bookings/<?php echo $event_id; ?>">Bookings</a></li>
	  <li><a href="<?php echo base_url();?>events/event_url/<?php echo $event_id; ?>">Event URL</a></li>
	</ul>

	<div class="tab-content">

	  	<div id="eventbookings" class="tab-pane fade in active">

			<br><br>

			<?php if (count($event_bookings) > 0): ?>

		    <table id="eventbookings-table" class="table table-hover">
		    <thead>
		    	<tr>
		        	<th>Ticket ID</th>
		        	<th>Customer Name</th>
		        	<th>Ticket Type</th>
		        </tr>
		    </thead>
		    <tbody>
		    	<?php foreach ($event_bookings as $booking): ?>
		        <tr>
		            <td class="col-sm-4"><?php echo $booking->ticket_no; ?></td>
		            <td class="col-sm-4"><?php echo $booking->first_name . " " . $booking->last_name; ?></td>
		            <td class="col-sm-4"><?php echo $booking->ticket_type; ?></td>
		        </tr>
		    	<?php endforeach; ?>
		    </tbody>
			</table>

			<?php else: ?>

				<p>There are currently no bookings on this event.</p>

			<?php endif; ?>

	  	</div>

	</div>

</div>