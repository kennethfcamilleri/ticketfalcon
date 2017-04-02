<div class="col-md-8 col-md-offset-2">

	<h4>Add Ticket Type</h4>

	<br>

	<ul class="nav nav-tabs">
	  <li><a href="<?php echo base_url();?>events/manage/<?php echo $event_id; ?>">General</a></li>
	  <li class="active"><a href="<?php echo base_url();?>events/event_tickets/<?php echo $event_id; ?>">Tickets</a></li>
	  <li><a href="<?php echo base_url();?>events/event_bookings/<?php echo $event_id; ?>">Bookings</a></li>
	  <li><a href="<?php echo base_url();?>events/event_url/<?php echo $event_id; ?>">Event URL</a></li>
	</ul>

	<div class="tab-content">

	    <div id="eventtickets" class="tab-pane fade in active">

	    	<br>

			<form action="<?php echo base_url();?>events/add_tickettype/<?php echo $event_id; ?>" id="addtickettype_form" class="form_horizontal" method="post" accept-charset="utf-8">

			<div class="form-group">
			    <table id="addticket-table" class="table">
			    
			    <thead>
			        <tr>
			            <th>Ticket Name</th>
			            <th>Quantity</th>
			            <th>Price</th>
			        </tr>
			    </thead>
			    
			    <tbody>
			        <tr class="ticket-row">
			            <td class="col-sm-4">
			                <input type="hidden" name="ticket_type_id"/>
			                <input type="text" name="ticket_type" class="form-control" placeholder="e.g. Early Bird" required/>
			            </td>
			            <td class="col-sm-4">
			                <input type="number" min="1" max="5000" name="quantity_available" class="form-control" required/>
			            </td>
			            <td class="col-sm-4">
			            	<div class="input-group">
				            	<span class="input-group-addon">€</span>
				                <input type="number" min="0.10" max="999" step="any" name="ticket_price" class="form-control" required/>
			                </div>
			            </td>
			        </tr>
			    </tbody>

			    <tfoot>
			        <tr>
			            <td colspan="3" style="text-align: center;">
			            	<br>
			                <div class="form-group">
			                	<button type="button" class="btn btn-default" onclick="javascript:window.history.go(-1);">Cancel</button>
			                	&nbsp;&nbsp;
							    <input type="submit" class="btn btn-success" value="Add ticket type" />
							</div>
			            </td>
			        </tr>
			        <tr>
			        </tr>
			    </tfoot>

			</table>
			</div>

			</form>

		</div>

	</div>

</div>
