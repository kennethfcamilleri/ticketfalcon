<div class="col-md-8 col-md-offset-2">

<div id="warning-message">
	<?php

	if($this->session->flashdata('quantity_error')) {
		echo $this->session->flashdata('quantity_error');
	}

	?>
</div>

<form id="checkout_form" class="col-sm-12" action="submit_order" method="post">
<div class="panel-group">
	<div class="panel panel-primary">
	  <div class="panel-heading">Order Summary</div>
	  <div class="panel-body">

		<div class="form-group">
		    <table id="ordersummary-table" class="table table-bordered">
		    <thead>
		    	<tr>
		        	<td>Ticket Type</td>
		        	<td>Price</td>
		        	<td>Quantity</td>
		        	<td>Subtotal</td>
		        </tr>
		    </thead>
		    <tbody>

		    	<?php $count = 0; ?>

		    	<?php foreach ($order_summary as $order_line) { ?>

		        <tr>
		            <td class="col-sm-5">
						<input type="hidden" name="<?php echo "tickettypes[" . $count . "][tickettype_id]"?>" value="<?php echo $order_line['ticket_type_id']; ?>"/>
		            	<?php echo $order_line['ticket_type']; ?>	
		            </td>
		            <td class="col-sm-2">&euro;<?php echo $order_line['ticket_price']; ?></td>
		            <td class="col-sm-2">
						<input type="hidden" name="<?php echo "tickettypes[" . $count . "][quantity]"?>" value="<?php echo $order_line['quantity']; ?>"/>
		            	<?php echo $order_line['quantity']; ?>		
		            </td>
		            <td class="col-sm-3">&euro;<?php echo $order_line['subtotal']; ?></td>
		        </tr>

		        <tr><td colspan="4"><br></td></tr>

				<?php $count++; ?>

		        <?php } ?>

		        <tr>
		            <td class="col-sm-5"></td>
		            <td class="col-sm-2"><input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>"/></td>
		            <td class="col-sm-2">Total:</td>
		            <td class="col-sm-3">&euro;<?php echo $total_amount; ?></td>
		        </tr>

		    </tbody>
			</table>

		</div>

	  </div>
	</div>
</div>

<div class="panel-group">
	<div class="panel panel-primary">
	  <div class="panel-heading">Payment</div>
	  <div class="panel-body">

		  <div class="form-group">
		    <label for="paymentmethod">Payment Method:</label>
		    <div>
		        <select class="form-control" name="paymentmethod" required>
				  <option>PayPal</option>
				</select>
		    </div>
		  </div>

		  <div class="form-group text-center">
		    <div>
        		<button type="button" class="btn btn-default" onclick="javascript:window.history.go(-1);">Back</button>
				&nbsp;&nbsp;
		      	<button type="submit" class="btn btn-success">Make Payment</button>
		    </div>
		  </div>
	  </div>
	</div>
</div>

</form>

</div>