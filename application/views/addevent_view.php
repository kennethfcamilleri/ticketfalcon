<div class="col-md-8 col-md-offset-2">

<h2>Create Event</h2>

<?php $attr = array('id' => 'addevent_form', 'class' => 'form_horizontal'); ?>

<?php 
	
	if($this->session->flashdata('errors')) {
		echo $this->session->flashdata('errors');
	}

?>

<?php echo form_open('events/add',$attr); ?>

<div class="form-group">

	<?php echo form_label('Title:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'title',
		'placeholder' => 'Enter event title',
		'required' => 'required'
		);
	?>

	<?php echo form_input($data); ?>

</div>



<div class="form-group">

	<?php echo form_label('Description:'); ?>

	<?php 

	    $data = array(
        'name'        => 'description',
        'id'          => 'description',
        'value'       => set_value('description'),
        'rows'        => '5',
        'cols'        => '10',
        'placeholder' => 'Enter event description',
        'class'       => 'form-control',
        'required' 	  => 'required'
    	);

	?>

	<?php echo form_textarea($data); ?>

</div>

<div class="form-group">

	<?php echo form_label('Location:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'location',
		'placeholder' => 'Enter event location',
		'required' => 'required'
		);
	?>

	<?php echo form_input($data); ?>

</div>

<div class="form-group">
	<?php echo form_label('Start Date:'); ?>
    <div class='input-group date' id='datetimepicker6'>

    	<?php $data = array(
			'class' => 'form-control',
			'name' => 'startdate',
			'type' => 'text',
			'placeholder' => 'Choose event start date and time',
			'required' => 'required'
			);
		?>

		<?php echo form_input($data); ?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<div class="form-group">
	<?php echo form_label('End Date:'); ?>
    <div class='input-group date' id='datetimepicker7'>

        <?php $data = array(
			'class' => 'form-control',
			'name' => 'enddate',
			'type' => 'text',
			'placeholder' => 'Choose event end date and time',
			'required' => 'required'
			);
		?>

		<?php echo form_input($data); ?>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>

<h2>Create Tickets</h2>

<div class="form-group">
    <table id="ticketTable" class="table ticket-types">
    <thead>
        <tr>
            <td>Ticket Name</td>
            <td>Quantity</td>
            <td>Price</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="col-sm-4">
                <input type="text" name="tickets[0][ticketname]" class="form-control" placeholder="e.g. Early Bird" required/>
            </td>
            <td class="col-sm-3">
                <input type="number" min="1" max="5000" name="tickets[0][quantity]" class="form-control" required/>
            </td>
            <td class="col-sm-3">
            	<div class="input-group">
	            	<span class="input-group-addon">€</span>
	                <input type="number" min="0.10" max="999" step="any" name="tickets[0][price]" class="form-control" required/>
                </div>
            </td>
            <td class="col-sm-2"><a class="deleteRow"></a>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align: left;">
                <input type="button" class="btn btn-default btn-lg btn-block" id="addtickettype" value="Add New Ticket Type" />
            </td>
        </tr>
        <tr>
        </tr>
    </tfoot>
</table>
</div>

<h2>PayPal Account</h2>

<div class="form-group">

	<?php echo form_label('Your PayPal email address:'); ?>

	<?php $data = array(
		'class' => 'form-control',
		'name' => 'paypalemail',
		'placeholder' => 'Enter your PayPal email address',
		'type' => 'email',
		'required' => 'required'
		);
	?>

	<?php echo form_input($data); ?>
	
</div>

<div class="form-group">

	<?php $data = array(
		'class' => 'btn btn-lg btn-primary btn-block',
		'name' => 'submit',
		'value' => 'Create Event'
		);
	?>

	<?php echo form_submit($data); ?>
	
</div>

<br>

</div>

<?php echo form_close(); ?>

<!-- The below script has been retrieved from https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script type="text/javascript">
    $(function () {
        $('#datetimepicker6').datetimepicker({
        	minDate: moment()
        });
        $('#datetimepicker7').datetimepicker({
            useCurrent: false
        });
        $("#datetimepicker6").on("dp.change", function (e) {
            $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimepicker7").on("dp.change", function (e) {
            $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
        });
    });
</script>


<script type="text/javascript">

$(document).ready(function () {
    var counter = 1;

    $("#addtickettype").on("click", function () {
        var row = $("<tr>");
        var columns = "";

        columns += '<td><input type="text" class="form-control" name="tickets[' + counter + '][ticketname]" placeholder="e.g. Early Bird" required/></td>';
        columns += '<td><input type="number" min="1" max="5000" class="form-control" name="tickets[' + counter + '][quantity]" required/></td>';
        columns += '<td><div class="input-group"><span class="input-group-addon">€</span>';
        columns += '<input type="number" min="0.10" max="999" step="any" class="form-control" name="tickets[' + counter + '][price]" required/></td></div>';

        columns += '<td><input type="button" class="btnDel btn btn-md btn-danger " value="Delete"></td>';
        row.append(columns);
        $("table.ticket-types").append(row);
        counter++;
    });

    $("table.ticket-types").on("click", ".btnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });

});

</script>

