<div class="col-md-8 col-md-offset-2">

<h3>Event Details</h3>

<br>

<ul class="nav nav-tabs">
  <li class="active"><a href="<?php echo base_url();?>events/manage/<?php echo $event_details->event_id; ?>">General</a></li>
  <li><a href="<?php echo base_url();?>events/event_tickets/<?php echo $event_details->event_id; ?>">Tickets</a></li>
  <li><a href="<?php echo base_url();?>events/event_bookings/<?php echo $event_details->event_id; ?>">Bookings</a></li>
  <li><a href="<?php echo base_url();?>events/event_url/<?php echo $event_details->event_id; ?>">Event URL</a></li>
</ul>

<div class="tab-content">
  <div id="eventdetails" class="tab-pane fade in active">

<br>

<?php if($this->session->flashdata('event_updated')): ?>

<div class="alert alert-success alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> <?php echo $this->session->flashdata('event_updated'); ?>
</div>

<?php elseif($this->session->flashdata('error')): ?>

<div class="alert alert-danger alert-dismissable">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
</div>

<?php endif; ?>

<h4>Edit Details</h4>

<br>

<form action="<?php echo base_url();?>events/update" id="addevent_form" class="form_horizontal" method="post" accept-charset="utf-8">

<div class="form-group">
    <input type="hidden" name="event_id" value="<?php echo $event_details->event_id; ?>"/>

	<label>Title:</label>
	
	<input type="text" name="title" value="<?php echo $event_details->event_name; ?>" class="form-control" placeholder="Enter event title" required="required" />

</div>



<div class="form-group">

	<label>Description:</label>
	
	<textarea name="description" cols="10" rows="5" id="description" placeholder="Enter event description" class="form-control" required="required" ><?php echo $event_details->event_description; ?></textarea>

</div>


<div class="form-group">

	<label>Location:</label>
	
	<input type="text" name="location" value="<?php echo $event_details->event_location; ?>" class="form-control" placeholder="Enter event location" required="required" />

</div>



<div class="form-group">

	<label>Start Date:</label>

    <div class='input-group date' id='datetimepicker6'>

		<input type="text" name="startdate" value="<?php echo date('m/d/Y g:i a',strtotime($event_details->start_date)); ?>" class="form-control" placeholder="Choose event start date and time" required="required"  />

        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>

    </div>
</div>

<div class="form-group">

	<label>End Date:</label>

    <div class='input-group date' id='datetimepicker7'>

		<input type="text" name="enddate" value="<?php echo date('m/d/Y g:i a',strtotime($event_details->end_date)); ?>" class="form-control" placeholder="Choose event end date and time" required="required"  />
        
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>

    </div>
</div>

<div class="form-group">
	<label>PayPal Email Address:</label>

	<input type="email" value="<?php echo $event_details->paypal_account; ?>" name="paypalemail" value="" class="form-control" placeholder="Enter your PayPal email address" required="required" />
</div>

<div class="form-group">
  <label for="eventstatus">Event Status:</label>
  <select class="form-control" name="eventstatus">
    <option value="1" <?php if($event_details->event_active =="1") echo 'selected="selected"'; ?>>Active</option>
    <option value="0" <?php if($event_details->event_active =="0") echo 'selected="selected"'; ?>>Inactive</option>
  </select>
</div>

<br>

<div class="form-group">

	<input type="submit" name="submit" value="Update Event" class="btn btn-lg btn-primary btn-block" />
	
</div>

<br>

</form>

  </div>
</div>

</div>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker({
        	//minDate: moment(),
            //format: 'DD/MM/YYYY hh:mm A'
        });
        $('#datetimepicker7').datetimepicker({
            useCurrent: false,
            //format: 'DD/MM/YYYY hh:mm A'
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>