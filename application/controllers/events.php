<?php

	class Events extends CI_Controller {

		public function add() {
			$this->form_validation->set_rules('title','Title','trim|required|min_length[3]');
			$this->form_validation->set_rules('description','Description','trim|required|min_length[3]');
			$this->form_validation->set_rules('location','Location','trim|required|min_length[3]');
			$this->form_validation->set_rules('startdate','Start Date','trim|required');
			$this->form_validation->set_rules('enddate','End Date','trim|required');
			$this->form_validation->set_rules('paypalemail','PayPal Email','trim|required|min_length[3]');

			// If validation did not pass
			if ($this->form_validation->run() == False) {
				$data = array(
					'errors' => validation_errors()
					);

				$this->session->set_flashdata($data);

				redirect('events/addevent_form');
			} // If validation is correct
			else { 
				if ($this->event_model->add_event()) {

					if($this->event_model->add_tickets()) {

						$this->session->set_flashdata('success', 'Event has been successfully created!');
						redirect('events/manage_events');		
					}
				}
			}
		}

		public function update() {
			$event_id = $this->input->post('event_id');

			// convert start date into mysql datetime format
			$startdate = $this->input->post('startdate');
			$startdate = strtotime($startdate); 
			$startdate = date("Y-m-d H:i:s", $startdate);

			// convert end date into mysql datetime format
			$enddate = $this->input->post('enddate');
			$enddate = strtotime($enddate); 
			$enddate = date("Y-m-d H:i:s", $enddate);

			$data = array(
				'event_name' => $this->input->post('title',true),
				'event_description' => $this->input->post('description',true),
				'event_location' => $this->input->post('location',true),
				'start_date' => $startdate,
				'end_date' => $enddate,
				'paypal_account' => $this->input->post('paypalemail'),
				'event_active' => $this->input->post('eventstatus')
				);

			$this->event_model->update_event($event_id, $data);

			$ticket_data = $this->input->post('tickets');

			$this->session->set_flashdata('event_updated','The event has been successfuly updated!');

			redirect('events/manage/'.$event_id);
		}

		public function search() {
			$keyword = $this->input->post('search');

			$data['search_results'] = $this->event_model->get_searchresults($keyword);
			$data['main_view'] = "search_view";

			$this->load->view('layouts/main',$data);		
		}

		public function event_url($event_id = 0) {

			if (isset($event_id)) {

				if ($this->authorized_user($event_id)) { // user is authorized to view event url

					$data['event_url'] = base_url() . "events/show/".$event_id."/";
					$data['event_id'] = $event_id;
					$data['main_view'] = "eventurl_view";

					$this->load->view('layouts/main',$data);
				}
				else { // page not found or user not authorized to view event url
					$data['main_view'] = "invalid_url_view";

					$this->load->view('layouts/main',$data);
				}
			}
		}

		public function event_bookings($event_id = 0) {

			if (isset($event_id)) {

				if ($this->authorized_user($event_id)) { // user is authorized to view event bookings

					$data['event_bookings'] = $this->event_model->get_eventbookings($event_id);
					$data['event_id'] = $event_id;
					$data['main_view'] = "eventbookings_view";

					$this->load->view('layouts/main',$data);
				}
				else { // page not found or user not authorized to view event bookings
					$data['main_view'] = "invalid_url_view";

					$this->load->view('layouts/main',$data);
				}
			}
		}

		public function event_tickets($event_id = 0) {

			if (isset($event_id)) {

				if ($this->authorized_user($event_id)) { // user is authorized to manage event tickets
					$data['tickets'] = $this->event_model->get_tickets($event_id);
					$data['event_id'] = $event_id;
					$data['main_view'] = "eventtickets_view";

					$this->load->view('layouts/main',$data);
				}
				else { // page not found or user not authorized to manage event tickets
					$data['main_view'] = "invalid_url_view";

					$this->load->view('layouts/main',$data);
				}

			}
		}

		public function manage($event_id = 0) {

			if (isset($event_id)) {

				if ($this->authorized_user($event_id)) { // user is authorized to manage event details

					$data['event_url'] = base_url() . "events/show/".$event_id."/";
					$data['event_details'] = $this->event_model->get_eventdata($event_id);
					$data['event_bookings'] = $this->event_model->get_eventbookings($event_id);
					$data['tickets'] = $this->event_model->get_tickets($event_id);
					$data['event_id'] = $event_id;
					$data['main_view'] = "eventdetails_view";

					$this->load->view('layouts/main',$data);
				}
				else { // page not found or user is not authorized to manage event details 
					$data['main_view'] = "invalid_url_view";

					$this->load->view('layouts/main',$data);
				}
			}

		}

		public function delete($event_id = 0) {

			if (isset($event_id)) {

				if ($this->authorized_user($event_id)) { // user is authorized to delete event

					// check if there are bookings on the event
					$event_bookings = $this->event_model->get_eventbookings($event_id);

					if (count($event_bookings) > 0) { // event has bookings

						$this->session->set_flashdata('error','Event cannot be deleted as it already has bookings related to it.');
						redirect('events/manage_events');
					}
					else if (count($event_bookings) == 0) { // event has no bookings

						if ($this->event_model->delete_event($event_id)) { // event deleted

							$this->session->set_flashdata('success','The event has been successfully deleted.');
							redirect('events/manage_events/');
						}
						else { // event not deleted

							$this->session->set_flashdata('error','An error occured while trying to delete the event.');
							redirect('events/manage_events/');
						}
					}
				}
				else { // page not found or user is not authorized to manage event details 
					$data['main_view'] = "invalid_url_view";

					$this->load->view('layouts/main',$data);
				}
			}	
		}

		public function authorized_user($event_id) {
			$event_user = $this->event_model->get_event_user($event_id);

			if (isset($event_user)) {

				if ($event_user->user_id == $this->session->userdata('user_id')) {
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}

		}

		public function show_ticketform($event_id) {

			if (isset($event_id)) {

				if ($this->authorized_user($event_id)) { // user is authorized to add ticket

					$data['main_view'] = "addticket_view";
					$data['event_id'] = $event_id;

					$this->load->view('layouts/main',$data);
				}
				else { // page not found or user is not authorized to add ticket type

					$data['main_view'] = "invalid_url_view";
					$this->load->view('layouts/main',$data);
				}
			}
		}

		public function add_tickettype($event_id) {
			$data = array(
				'event_id' => $event_id,
				'ticket_type' => $this->input->post('ticket_type',true),
				'ticket_price' => $this->input->post('ticket_price'),
				'quantity_available' => $this->input->post('quantity_available'),
				'tickets_sold' => 0
				);

			if ($this->event_model->add_ticket($data)) {

				$this->session->set_flashdata('success','The new ticket type has been added successfuly!');
				redirect('events/event_tickets/'.$event_id);
			}
			else {

				$this->session->set_flashdata('error','An error occured: The record was not deleted!');
				redirect('events/event_tickets/'.$event_id);
			}
		}

		public function manage_events() {

			if ($this->session->userdata('logged_in')) {

				$user_id = $this->session->userdata('user_id');

				$data['events_summary'] = $this->event_model->get_events_summary($user_id);
				$data['main_view'] = "manageevents_view";

				$this->load->view('layouts/main',$data);
			}
			else {
				redirect('users/login_form');
			}
		}

		public function update_tickettype($tickettype_id) {
			$data = array(
				'ticket_type' => $this->input->post('ticket_type',true),
				'ticket_price' => $this->input->post('ticket_price'),
				'quantity_available' => $this->input->post('quantity_available')
				);

			$quantity_available = $this->input->post('quantity_available');

			$ticket_type_data = $this->event_model->get_tickettype_data($tickettype_id);

			$event_id = $ticket_type_data->event_id;

			// check how many bookings there are on the ticket type
			$ticket_type_bookings = $this->event_model->get_ticket_type_bookings($tickettype_id);


			if (count($ticket_type_bookings) <= $quantity_available) { // bookings does not exceed quantity available

				if ($this->event_model->update_ticket($tickettype_id, $data)) {

					$this->session->set_flashdata('success','The ticket type was updated successfuly!');
					redirect('events/event_tickets/'.$event_id);
				}
				else {

					$this->session->set_flashdata('error','An error occured while trying to update the ticket type.');
					redirect('events/event_tickets/'.$event_id);
				}
			}
			else if (count($ticket_type_bookings) > $quantity_available) { // bookings exceed available quantity

				// bookings cannot exceed the quantity available

				$total_bookings = count($ticket_type_bookings);

				$error_msg = "You already have ".$total_bookings." bookings on this ticket type. The quantity cannot be less than this amount.";

				$this->session->set_flashdata('error',$error_msg);
				redirect('events/edit_ticket/'.$event_id.'/'.$tickettype_id);
			}

		}

		public function edit_ticket($event_id = 0, $tickettype_id = 0) {

			if (isset($event_id) && isset($tickettype_id)) {

				if ($this->authorized_user($event_id) && $this->valid_ticket_type_id($event_id,$tickettype_id)) { // user authorized to edit

					// check if there are any bookings on this ticket type prior deleting the data
					$ticket_type_bookings = $this->event_model->get_ticket_type_bookings($tickettype_id);

					if (count($ticket_type_bookings) > 0) { // ticket type has bookings
						$data['tickets_booked'] = true;
					}
					else {
						$data['tickets_booked'] = false;
					}

					$data['main_view'] = "editticket_view";
					$data['event_id'] = $event_id;
					$data['tickettype_data'] = $this->event_model->get_tickettype_data($tickettype_id);

					$this->load->view('layouts/main',$data);
				}
				else { // page not found or user is not authorized to edit ticket details 

					$data['main_view'] = "invalid_url_view";
					$this->load->view('layouts/main',$data);
				}
			}
		}

		public function valid_ticket_type_id($event_id, $tickettype_id) {

			$ticket_type_data = $this->event_model->get_tickettype_data($tickettype_id);

			if (count($ticket_type_data) > 0) {
				if ($event_id == $ticket_type_data->event_id) {
					return true;
				}
				else {
					return false;
				}
			}
			else {
				return false;
			}
		}

		public function delete_ticket($event_id = 0, $tickettype_id = 0) {

			if (isset($event_id) && isset($tickettype_id)) {

				if ($this->authorized_user($event_id) && $this->valid_ticket_type_id($event_id,$tickettype_id)) { // user authorized to delete

					// check if there are any bookings on this ticket type prior deleting the data
					$ticket_type_bookings = $this->event_model->get_ticket_type_bookings($tickettype_id);

					if (count($ticket_type_bookings) > 0) { // ticket type has bookings

						$this->session->set_flashdata('error','Ticket type cannot be deleted as it already has bookings related to it.');
						redirect('events/event_tickets/'.$event_id);
					}
					else { // ticket type has no bookings

						$tickets = $this->event_model->get_tickets($event_id);

						if (count($tickets) > 1) {
							if ($this->event_model->delete_ticket($tickettype_id)) { // ticket deleted

								$this->session->set_flashdata('success','The ticket type has been successfully deleted.');
								redirect('events/event_tickets/'.$event_id);
							}
							else { // ticket not deleted

								$this->session->set_flashdata('error','An error occured while trying to delete the ticket type.');
								redirect('events/event_tickets/'.$event_id);
							}
						}
						else if (count($tickets) == 1) { // Don't delete ticket if only one ticket type is remaining
							$this->session->set_flashdata('error','You must have at least one ticket type for an event.');
							redirect('events/event_tickets/'.$event_id);
						}

					}
				}
				else { // page not found or user is not authorized to delete ticket type

					$data['main_view'] = "invalid_url_view";
					$this->load->view('layouts/main',$data);
				}
			}
		}

		public function submit_order() {
			$order_data = $this->input->post('tickettypes');
			$total_amount = $this->input->post('total_amount');

			$tickettype_id = $order_data[0]['tickettype_id'];
			$ticketdata_db = $this->event_model->get_tickettype_data($tickettype_id);
			$event_id = $ticketdata_db->event_id;

			if($this->event_model->create_booking($event_id)) {

				$booking_id = $this->db->insert_id();

				foreach ($order_data as $order_line) {

					$tickettype_id = $order_line['tickettype_id'];
					$quantity_ordered = $order_line['quantity'];

					$ticketdata_db = $this->event_model->get_tickettype_data($tickettype_id);
					
					$quantity_remaining = $ticketdata_db->quantity_available - $ticketdata_db->tickets_sold;
					$quantity_remaining = $quantity_remaining - $quantity_ordered;

					if ($quantity_remaining < 0) {
						$error = "<p class='bg-warning'>Only ". $quantity_remaining ." ". $ticketdata_db->ticket_type . " ticket(s) remaining! Please go back to change the order.</p>";

						$this->session->set_flashdata('quantity_error', $error);

						redirect($this->agent->referrer());
					}
					else {

						$tickets_sold = $ticketdata_db->tickets_sold + $quantity_ordered;
						$this->event_model->update_tickets_sold($tickettype_id,$tickets_sold);
					}

					for ($x = 0; $x < $quantity_ordered; $x++) {
						$booking_lines[] = array(
					 		'booking_id' => $booking_id,
					 		'ticket_type_id' => $tickettype_id,
					 		);
					}
				}

				if ($this->event_model->create_bookinglines($booking_lines)) {
					
					// Create Payment Transaction

					$payment_date = date('Y-m-d H:i:s');

					$payment_data = array(
						'user_id' => $this->session->userdata('user_id'),
						'booking_id' => $booking_id,
						'payment_method_id' => 1,
						'payment_date' => $payment_date,
						'payment_amount' => $total_amount
						);

					$this->event_model->insert_payment_data($payment_data);

					// Create Tickets PDF file

					$pdfFilePath = $this->create_tickets($booking_id,"F");
					$event_details = $this->event_model->get_booked_event($booking_id);

					
					if ($this->send_email($pdfFilePath, $event_details)) {
						$data['main_view'] = "ordercompleted_view";
						$data['booking_id'] = $booking_id;
						$this->load->view('layouts/main',$data);						
					}
					else {
						// something went wrong...
					}
				}
				else {
					// something went wrong...
				}
			}	
		}

		public function downloadtickets($booking_id) {

			// prompt user to download tickets
			$this->create_tickets($booking_id,"D");
		}

		public function create_tickets($booking_id,$output_code) {
			$event_details = $this->event_model->get_booked_event($booking_id);
			//$ticketcount = $this->event_model->get_ticket_count($booking_id);
			$ticket_data = $this->event_model->get_ticket_data($booking_id);
			//$ticket_count = $ticket_data->num_rows();

			foreach ($ticket_data as $row) {
				$ticket_lines[] = array(
					'event_title' => $event_details->event_name,
					'event_date' => $event_details->start_date,
					'ticket_type' => $row->ticket_type,
					'ticket_price' => $row->ticket_price,
					'ticket_code' => $row->ticket_no
					);
			}

			// $ticket_lines = array(
			// 	'ticket_lines' => $ticket_lines
			// 	);

			$pdfFilePath = $this->create_pdf_document($ticket_lines, $output_code);

			return $pdfFilePath;

			// $this->htmlticket($ticket_lines);
		}

		public function create_pdf_document($ticket_lines, $output_code) {
			// load mPDF library
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
	 
			foreach ($ticket_lines as $ticket_line) {

				$data = array(
					'ticket_line' => $ticket_line
					);

		 		// set the CSS for the PDF
		 		$stylesheet = '<style>'.file_get_contents('assets/css/pdf.css').'</style>';

		 		// set the HTML to convert to PDF
				$html = $this->load->view('htmlticket_view',$data, true);
		 	 
				// set the filename for the PDF
				if ($output_code == "D") {
					$pdfFilePath = "ticketfalcon-".time()."-download.pdf";
				}
				else if ($output_code == "F") {
					$pdfFilePath = "assets/tickets/ticketfalcon-".time().".pdf";
				}

	   			$pdf->AddPage('P', // L - landscape, P - portrait
	            '', '', '', '',
	            20, // margin_left
	            20, // margin right
	            20, // margin top
	            20, // margin bottom
	            10, // margin header
	            10); // margin footer

				// write CSS data
				$pdf->WriteHTML($stylesheet,1);

				// write the HTML data
				$pdf->WriteHTML($html,2);
			}

			// "F" = saves the file directly to the given path
			// "D" = prompt user to save the PDF

			$pdf->Output($pdfFilePath, $output_code);

			return $pdfFilePath;
		}

		public function send_email($pdfFilePath,$event_details) {

			$config['protocol'] = "smtp";
		    $config['smtp_host'] = "ssl://smtp.gmail.com";
		    $config['smtp_port'] = "465";
		    $config['smtp_user'] = "ticketfalcon.mail@gmail.com";
		    $config['smtp_pass'] = "TicketFalcon786";
		    $config['charset'] = "utf-8";
		    $config['mailtype'] = "html";
		    $config['newline'] = "\r\n";

		    $fullname = $this->session->userdata('fullname');

		    $subject = "Your order for ".$event_details->event_name;

		    $message = "Dear ".$fullname.",<br><br>Your order for <strong>".$event_details->event_name."</strong> has been confirmed.<br><br>";
		    $message .= "Attached you shall find the ticket(s) for the event.<br><br>";
		    $message .= "Thank you!<br><br>";
		    $message .= "<strong>The Ticket Falcon Team.</strong>";
		    		
		    $this->email->initialize($config);

			$this->email->to('ticketfalcon.mail@gmail.com');
			$this->email->from('ticketfalcon.mail@gmail.com','Ticket Falcon');
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->attach($pdfFilePath);

			if($this->email->send()) {
	        	return true;
	        }
	        else
	        {
	        	show_error($this->email->print_debugger());
	        }
		}

		public function htmlticket($ticket_lines) {

			//$data['main_view'] = "htmlticket_view";
			foreach ($ticket_lines as $ticket_line) {
				$data = array(
					'ticket_line' => $ticket_line,
					'main_view' => 'htmlticket_view'
					);

				$this->load->view('layouts/main',$data);
			}
		}

		public function ticketoutput() {
			// load mPDF library
			$this->load->library('pdf');
			$pdf = $this->pdf->load();
	 
			// set the data for the view
			$data = array(
				'event_title' => "Rhythm District pres. DOSEM",
				'event_date' => "Tuesday 6th of June 2017 10:00 PM",
				'ticket_type' => "Early Bird",
				'ticket_price' => "35.00",
				'ticket_code' => "1000000019",
				'main_view' => "htmlticket_view"
				);
	 
	 		// set the CSS for the PDF
	 		$stylesheet = '<style>'.file_get_contents('assets/css/pdf.css').'</style>';

	 		// set the HTML to convert to PDF
			$html = $this->load->view('htmlticket_view',$data, true);
	 	 
			// set the filename for the PDF
			$pdfFilePath ="mypdfName-".time()."-download.pdf";

   			$pdf->AddPage('P', // L - landscape, P - portrait
            '', '', '', '',
            20, // margin_left
            20, // margin right
            20, // margin top
            20, // margin bottom
            10, // margin header
            10); // margin footer

			// write CSS data
			$pdf->WriteHTML($stylesheet,1);

			// write the HTML data
			$pdf->WriteHTML($html,2);

			// $pdf->AddPage('P', // L - landscape, P - portrait
   //          '', '', '', '',
   //          20, // margin_left
   //          20, // margin right
   //          20, // margin top
   //          20, // margin bottom
   //          10, // margin header
   //          10); // margin footer

			// // write CSS data
			// $pdf->WriteHTML($stylesheet,1);

			// // write the HTML data
			// $pdf->WriteHTML($html,2);

			// prompt user to save the PDF
			$pdf->Output($pdfFilePath, "D");
		}

		public function checkout() {

			if ($this->session->userdata('logged_in')) {

				if ($this->input->post('tickettypes')) {

					$order_data = $this->input->post('tickettypes');
					$total = 0;
					$subtotal = 0;
					$errors = "";

					foreach ($order_data as $order_line) {

						if (isset($order_line['quantity'])) {

							// check if user has chosen a quantity for this ticket type
							if ($order_line['quantity'] != "0") {
								$tickettype_id = $order_line['tickettype_id'];
								$ticketdata_db = $this->event_model->get_tickettype_data($tickettype_id);

								$quantity_remaining = $ticketdata_db->quantity_available - $ticketdata_db->tickets_sold;

								// check that there is enough quantity remaining
								if (($quantity_remaining - $order_line['quantity']) < 0) {
									$errors .= "<p class='bg-warning'>Only ". $quantity_remaining ." ". $ticketdata_db->ticket_type . " ticket(s) remaining!</p>";
								}

								$subtotal = $ticketdata_db->ticket_price * $order_line['quantity'];
								$total = $total + $subtotal;

								// create order summary array
							 	$order_summary[] = array(
							 		'ticket_type_id' => $tickettype_id,
							 		'ticket_type' => $ticketdata_db->ticket_type,
							 		'ticket_price' => $ticketdata_db->ticket_price,
							 		'quantity' => $order_line['quantity'],
							 		'subtotal' => $subtotal
							 		);
							}
						}
					}

					if ($errors != "") { // display quantity error(s)
						$this->session->set_flashdata('quantity_errors', $errors);
						redirect($this->agent->referrer());
					}
					else { // display order summary
						$data = array(
							'order_summary' => $order_summary,
							'total_amount' => $total,
							'main_view' => "checkout_view"
							);

						$this->load->view('layouts/main',$data);
					}
				}
				else {
					$data['main_view'] = "invalid_url_view";
					$this->load->view('layouts/main',$data);
				}
			}
			else {
				redirect('users/login_form');
			}
		}

		public function show($event_id = 0) {

			if (isset($event_id)) {

				if ($this->valid_event($event_id)) { // valid event id

					$data['event_details'] = $this->event_model->get_eventdata($event_id);
					$data['ticket_types'] = $this->event_model->get_tickets($event_id);

					$data['main_view'] = "event_view";

					$this->load->view('layouts/main',$data);	
				}
				else { // page not found

					$data['main_view'] = "invalid_url_view";
					$this->load->view('layouts/main',$data);
				}
			}
		}

		public function valid_event($event_id) {
			if ($this->event_model->get_eventdata($event_id)) {
				return true;
			}
			else {
				return false;
			}
		}

		public function addevent_form() {

			if ($this->session->userdata('logged_in')) {
				$data['main_view'] = "addevent_view";
				$this->load->view('layouts/main',$data);
			}
			else {
				redirect('users/login_form');
			}

		}

	}


?>

