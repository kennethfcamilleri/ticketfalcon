<div class="col-md-8 col-md-offset-2">

	<h3>Booking Details</h3>

	<br>

    <table class="table">
        <tr>
          <th class="col-sm-2">Event Name:</th>
          <td class="col-sm-10"><?php echo $booking->event_name; ?></td>
        </tr>
        <tr>
          <th>Booking Date:</th>
          <td><?php echo date('l jS \of F Y h:i A',strtotime($booking->booking_date)); ?></td>
        </tr>
    </table>

    <?php if (count($bookinglines) > 0): ?>

    <table id="userbookings-table" class="table table-hover">
    <thead>
        <tr>
            <th>Ticket No</th>
            <th>Ticket Type</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($bookinglines as $bookingline): ?>
            <tr>
                <td><?php echo $bookingline->ticket_no; ?></td>
                <td><?php echo $bookingline->ticket_type; ?></td>
                <td><?php echo $bookingline->ticket_price; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>

    &nbsp;
    <a href="<?php echo base_url();?>events/downloadtickets/<?php echo $booking->booking_id; ?>" class="btn btn-md btn-primary" role="button"><span class="glyphicon glyphicon-download-alt"></span> Download Ticket(s)</a>

    <br><br>

    <?php else: ?>

        <p>No booking details found.</p>

    <?php endif; ?>

    <br>

</div>