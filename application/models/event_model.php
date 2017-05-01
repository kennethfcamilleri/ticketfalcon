<?php

class Event_Model extends CI_Model {

	public function add_event() {

		// convert start date into mysql datetime format
		$startdate = $this->input->post('startdate');
		$startdate = strtotime($startdate); 
		$startdate = date("Y-m-d H:i:s", $startdate);

		// convert end date into mysql datetime format
		$enddate = $this->input->post('enddate');
		$enddate = strtotime($enddate); 
		$enddate = date("Y-m-d H:i:s", $enddate);

		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'event_name' => $this->input->post('title',true),
			'event_description' => $this->input->post('description',true),
			'event_location' => $this->input->post('location',true),
			'start_date' => $startdate,
			'end_date' => $enddate,
			'event_active' => 1,
			'paypal_account' => $this->input->post('paypalemail')
			);

		// insert data into db
		$insert_data = $this->db->insert('events',$data);

		return $insert_data;
	}

	public function create_booking($event_id) {

		$bookingdate = date('Y-m-d H:i:s');

		$data = array(
			'user_id' => $this->session->userdata('user_id'),
			'event_id' => $event_id,
			'booking_date' => $bookingdate,
			'booking_confirmed' => 1
			);

		$insert_data = $this->db->insert('bookings',$data);

		return $insert_data;	
	}

	public function insert_payment_data($payment_data) {
		$this->db->insert('payments',$payment_data);
	}

	public function create_bookinglines($booking_lines) {

		$insert_data = $this->db->insert_batch('booking_lines',$booking_lines);

		return $insert_data;
	}

	public function add_tickets() {
		// get all tickets to be added
		$ticket_data = $this->input->post('tickets',true);

		// get last insert id
		$event_id = $this->db->insert_id();

		// loop through all tickets and create data array
		foreach ($ticket_data as $ticket_type) {
			$data[] = array(
				'event_id' => $event_id,
				'ticket_type' => $ticket_type['ticketname'],
				'ticket_price' => $ticket_type['price'],
				'quantity_available' => $ticket_type['quantity'],
				'tickets_sold' => 0
				);
		}

		// insert tickets data into database
		$insert_data = $this->db->insert_batch('ticket_types',$data);

		return $insert_data;
	}

	public function get_tickettype_data($tickettype_id) {
		$this->db->where('ticket_type_id',$tickettype_id);
		$query = $this->db->get('ticket_types');

		return $query->row();
	}

	public function get_eventdata($event_id) {
		$this->db->where('event_id',$event_id);
		$query = $this->db->get('events');

		return $query->row();
	}

	public function get_tickets($event_id) {
		$this->db->where('event_id',$event_id);
		$query = $this->db->get('ticket_types');

		return $query->result();
	}

	public function get_booked_event($booking_id) {
		$this->db->select('events.event_id, event_name, start_date');
		$this->db->from('events');
		$this->db->join('bookings', 'events.event_id = bookings.event_id');
		$this->db->where('booking_id', $booking_id);

		$query = $this->db->get();

		return $query->row();
	}

	public function update_tickets_sold($tickettype_id,$tickets_sold) {
		$data = array('tickets_sold' => $tickets_sold);

		$this->db->where(['ticket_type_id' => $tickettype_id]);
		$this->db->update('ticket_types',$data);
	}

	public function update_event($event_id, $data) {
		$this->db->where(['event_id' => $event_id]);
		$this->db->update('events',$data);			
	}

	public function update_ticket($tickettype_id, $data) {
		$this->db->where(['ticket_type_id' => $tickettype_id]);
		$query = $this->db->update('ticket_types',$data);

		return $query;
	}

	public function add_ticket($data) {
		$insert_data = $this->db->insert('ticket_types',$data);

		return $insert_data;
	}

	public function get_ticket_data($booking_id) {
		$this->db->select('ticket_type, ticket_price, ticket_no');
		$this->db->from('ticket_types');
		$this->db->join('booking_lines', 'ticket_types.ticket_type_id = booking_lines.ticket_type_id');
		$this->db->where('booking_id', $booking_id);

		$query = $this->db->get();

		return $query->result();
	}

	public function get_ticket_type_bookings($tickettype_id) {
		$this->db->where('ticket_type_id',$tickettype_id);
		$query = $this->db->get('booking_lines');

		return $query->result();		
	}

	public function get_eventbookings($event_id) {
		$this->db->select('bookings.booking_id, booking_lines.ticket_no, users.first_name, users.last_name, ticket_types.ticket_type');
		$this->db->from('bookings');
		$this->db->join('booking_lines', 'bookings.booking_id=booking_lines.booking_id');
		$this->db->join('users', 'bookings.user_id=users.user_id');
		$this->db->join('ticket_types', 'booking_lines.ticket_type_id=ticket_types.ticket_type_id');
		$this->db->where('bookings.event_id', $event_id);

		$query = $this->db->get();

		return $query->result();
	}

	public function get_searchresults($keyword) {
		$this->db->like('event_name',$keyword);
		$this->db->where('event_active',1);
		$query = $this->db->get('events');

		return $query->result();
	}

	public function delete_ticket($tickettype_id) {
		$this->db->where('ticket_type_id', $tickettype_id);
  		$query = $this->db->delete('ticket_types');

  		return $query;
	}

	public function delete_event($event_id) {
		$this->db->where('event_id', $event_id);
  		$query = $this->db->delete('events');

  		return $query;	
	}

	public function get_recently_added_events() {
		$sql = "SELECT * FROM `events` WHERE event_active = 1 ORDER BY event_id DESC limit 3";

		$query = $this->db->query($sql);

		return $query->result();
	}

	public function get_events_summary($user_id) {

		$sql = "SELECT  events.event_id
				    , events.event_name
				    , events.start_date
				    , events.event_active
				    , SUM(ticket_types.quantity_available) AS quantity_available
				    , SUM(ticket_types.tickets_sold) AS tickets_sold
				FROM events
				    INNER JOIN ticket_types
				        ON events.event_id = ticket_types.event_id
				WHERE events.user_id = '$user_id'
				GROUP BY events.event_id
				    , events.event_name
				    , events.start_date
				    , events.event_active";

		$query = $this->db->query($sql);

		return $query->result();
	}

	public function get_event_user($event_id) {
		$this->db->select('user_id');
		$this->db->from('events');
		$this->db->where('event_id', $event_id);

		$query = $this->db->get();

		return $query->row();
	}
}
?>