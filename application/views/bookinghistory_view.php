<div class="col-md-8 col-md-offset-2">

	<h3>Booking History</h3>

	<br>

    <?php if (count($userbookings) > 0): ?>

    <table id="userbookings-table" class="table table-hover">
    <thead>
        <tr>
            <th>Booking ID</th>
            <th>Booking Date</th>
            <th>Event Name</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userbookings as $userbooking): ?>
            <tr class="tr-link" data-href="<?php echo base_url();?>users/bookingdetails/<?php echo $userbooking->booking_id; ?>">
                <td><?php echo $userbooking->booking_id; ?></td>
                <td><?php echo date('l jS \of F Y h:i A',strtotime($userbooking->booking_date)); ?></td>
                <td><?php echo $userbooking->event_name; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>

    <?php else: ?>

        <p>You haven't purchased any tickets yet.</p>

    <?php endif; ?>

    <br>

</div>

    
<script type="text/javascript">

    $('tr[data-href]').on("click", function() {
        document.location = $(this).data('href');
    });

</script>