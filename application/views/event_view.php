<div class="col-md-8 col-md-offset-2">

<h2><?php echo $event_details->event_name; ?></h2>

<table class="table">
	<tr>
	  <th class="col-sm-3">Location:</th>
	  <td class="col-sm-9"><?php echo $event_details->event_location; ?></td>
	</tr>
	<tr>
	  <th>Event Starts:</th>
	  <td><?php echo date('l jS \of F Y h:i A',strtotime($event_details->start_date)); ?></td>
	</tr>
	<tr>
	  <th>Event Ends:</th>
	  <td><?php echo date('l jS \of F Y h:i A',strtotime($event_details->end_date)); ?></td>
	</tr>
</table>

<div class="panel-group">
	<div class="panel panel-primary">
	  <div class="panel-heading">Tickets</div>
	  <div class="panel-body">

<?php $attr = array('id' => 'tickets_form', 'class' => 'form_horizontal'); ?>

<?php echo form_open('events/checkout',$attr); ?>

<div id="warning-message">
	<?php

	if($this->session->flashdata('quantity_errors')) {
		echo $this->session->flashdata('quantity_errors');
	}

	?>
</div>

<div class="form-group">
    <table id="buytickets-table" class="table table-bordered">
    <tbody>

    	<?php
    		$count = 0;

    		foreach ($ticket_types as $ticket_type) { 
    	?>

        <tr class="ticket-type">
            <td class="col-sm-10" style="vertical-align:middle">
            <input type="hidden" name="<?php echo "tickettypes[" . $count . "][tickettype_id]"?>" value="<?php echo $ticket_type->ticket_type_id; ?>"/>
			<h4>
				<?php echo $ticket_type->ticket_type; ?>

				<?php $quantity_remaining = $ticket_type->quantity_available - $ticket_type->tickets_sold; ?>

				<?php if ($quantity_remaining == 0): ?>
					<small> &euro;<span class="ticket-price"> <?php echo $ticket_type->ticket_price; ?></span> &nbsp; <span class="label label-danger">SOLD OUT!</span></small>
				<?php else: ?>
					<small> &euro;<span class="ticket-price"> <?php echo $ticket_type->ticket_price; ?></span></small>
				<?php endif; ?>
			</h4>
            </td>
            <td class="col-sm-2" style="vertical-align:middle">
                  <select name="<?php echo "tickettypes[" . $count . "][quantity]"?>" class="form-control quantity-dropdown" <?php if ($quantity_remaining == 0) { echo "disabled"; } ?>>
                  	<option value="0">0</option>
				    <option value="1">1</option>
				    <option value="2">2</option>
				    <option value="3">3</option>
				    <option value="4">4</option>
				    <option value="5">5</option>
				    <option value="6">6</option>
				    <option value="7">7</option>
				    <option value="8">8</option>
				    <option value="9">9</option>
				    <option value="10">10</option>
				  </select>
            </td>
        </tr>

        <?php
        	$count++; 
        	} 
        ?>

    </tbody>

</table>

<br>

<table class="table table-bordered">
	<tr>
		<td class="col-sm-4"><h5>Quantity: <span id="totalquantity">0</span></h5></td>
		<td class="col-sm-5"><h5>Subtotal: &euro;<span id="subtotal">0.00</span></h5></td>
		<td class="col-sm-3" style="text-align: right"><button type="submit" id="buytickets-btn" class="btn btn-success">Buy Tickets</button></td>
	</tr>
</table>

</div>

<?php echo form_close(); ?>


	  </div>
	</div>
</div>

<div class="panel-group">
	<div class="panel panel-primary">
	  <div class="panel-heading">Description</div>
	  <div class="panel-body"><?php echo nl2br($event_details->event_description); ?></div>
	</div>
</div>

</div>

<script type="text/javascript">


$(document).ready(function(){

    $(".quantity-dropdown").change(function(){

		var quantity = 0;
		var subtotal = 0;

    	$('.ticket-type').each(function(i, obj) {
    		$this = $(this);
    		ticketprice = parseFloat($this.find("span.ticket-price").text());
    		ticketquantity = parseInt($this.find("select.quantity-dropdown").val());
		    subtotal = subtotal + (ticketprice * ticketquantity);
		    quantity = quantity + ticketquantity;
		});

		$("#totalquantity").text(quantity);
		$("#subtotal").text(subtotal.toFixed(2));

    });


	$(function()
	{
	  $("#buytickets-btn").click(function(event)
	  {
	  	var q = parseInt($("#totalquantity").text());

		if(isNaN(q) || q === 0){
		  $('#warning-message').html("<p class='bg-warning'>You must select at least 1 ticket to continue.</p>");

		  event.preventDefault(); // do not submit the form
		}
	  });

	});
});

</script>


