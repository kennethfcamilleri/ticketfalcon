<div class="col-md-8 col-md-offset-2">

	<h3>Event Tickets</h3>

	<br>

	<ul class="nav nav-tabs">
	  <li><a href="<?php echo base_url();?>events/manage/<?php echo $event_id; ?>">General</a></li>
	  <li class="active"><a href="<?php echo base_url();?>events/event_tickets/<?php echo $event_id; ?>">Tickets</a></li>
	  <li><a href="<?php echo base_url();?>events/event_bookings/<?php echo $event_id; ?>">Bookings</a></li>
	  <li><a href="<?php echo base_url();?>events/event_url/<?php echo $event_id; ?>">Event URL</a></li>
	</ul>

	<div class="tab-content">

	    <div id="eventtickets" class="tab-pane fade in active">

	        <br><br>

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
		       
            <?php if (count($tickets) > 0): ?>

            <table id="eventbookings-table" class="table table-hover">
            <thead>
                <tr>
                    <th>Ticket Type</th>
                    <th>Total Tickets</th>
                    <th>Sold Tickets</th>
                    <th>Price</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $count = 0; ?>

                <?php foreach ($tickets as $ticket): ?>

                <tr>
                    <td><?php echo $ticket->ticket_type; ?></td>
                    <td><?php echo $ticket->quantity_available; ?></td>
                    <td><?php echo $ticket->tickets_sold; ?></td>
                    <td><?php echo $ticket->ticket_price; ?></td>
                    <td><a href="<?php echo base_url();?>events/edit_ticket/<?php echo $event_id; ?>/<?php echo $ticket->ticket_type_id; ?>" class="btn btn-sm btn-success" role="button">Edit</a></td>
                    <td><a href="<?php echo base_url();?>events/delete_ticket/<?php echo $event_id; ?>/<?php echo $ticket->ticket_type_id; ?>" class="btn btn-sm btn-danger" role="button">Delete</a></td>
                </tr>
                <?php endforeach; ?>

            </tbody>
            </table>

            <?php else: ?>

                <p>There are currently no tickets for this event.</p>

            <?php endif; ?>

            <a href="<?php echo base_url();?>events/show_ticketform/<?php echo $event_id; ?>" class="btn btn-md btn-primary" role="button"><span class="glyphicon glyphicon-plus"></span> Add ticket type</a>

            <br><br>

	    </div>

	</div>

</div>