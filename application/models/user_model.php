<?php

class User_Model extends CI_Model {

	public function login_user($username, $password) {
		$this->db->where('email_address',$username);

		$result = $this->db->get('users');

		if ($result->num_rows() == 1) {

			$db_password = $result->row(4)->user_password;

			if(password_verify($password,$db_password)) {
				return $result->row(0)->user_id;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}

	public function verify_password($password,$user_id) {
		$this->db->where('user_id',$user_id);

		$result = $this->db->get('users');

		if ($result->num_rows() == 1) {

			$db_password = $result->row(4)->user_password;

			if(password_verify($password,$db_password)) {
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

	public function update_password($password,$user_id) {
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);

		$data = array('user_password' => $hashed_password);

		$this->db->where(['user_id' => $user_id]);
		$this->db->update('users',$data);

		return true;
	}

	public function get_fullname($user_id) {
		$this->db->where('user_id',$user_id);

		$result = $this->db->get('users');

		if ($result->num_rows() == 1) {
			$firstname = $result->row(1)->first_name;
			$lastname = $result->row(2)->last_name;

			$fullname = $firstname . ' ' . $lastname;

			return $fullname;
		}
		else {
			return false;
		}
	}

	public function register_user() {

		$hashed_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);

		$data = array(
			'first_name' => $this->input->post('firstname',true), // returns POST item with XSS filter
			'last_name' => $this->input->post('lastname',true), // returns POST item with XSS filter
			'email_address' => $this->input->post('email',true), // returns POST item with XSS filter
			'user_password' => $hashed_password
			);

		$insert_data = $this->db->insert('users',$data);

		return $insert_data;
	}

	public function get_userdata($user_id) {
		$this->db->where('user_id',$user_id);
		$query = $this->db->get('users');

		return $query->row();
	}

	public function update_user($data,$id) {
		$this->db->where(['user_id' => $id]);
		$this->db->update('users',$data);

		return true;
	}

	public function get_booking($booking_id) {
		$this->db->select('bookings.booking_id, bookings.booking_date, events.event_name');
		$this->db->from('bookings');
		$this->db->join('events', 'bookings.event_id = events.event_id');
		$this->db->where('bookings.booking_id', $booking_id);

		$query = $this->db->get();

		return $query->row();
	}

	public function get_bookinglines($booking_id) {
		$this->db->select('booking_lines.ticket_no, ticket_types.ticket_type, ticket_types.ticket_price');
		$this->db->from('booking_lines');
		$this->db->join('ticket_types', 'booking_lines.ticket_type_id=ticket_types.ticket_type_id');
		$this->db->where('booking_lines.booking_id', $booking_id);

		$query = $this->db->get();

		return $query->result();
	}

	public function get_userbookings($user_id) {
		$this->db->select('bookings.booking_id, bookings.booking_date, events.event_name');
		$this->db->from('bookings');
		$this->db->join('booking_lines', 'bookings.booking_id=booking_lines.booking_id');
		$this->db->join('events', 'bookings.event_id = events.event_id');
		$this->db->where('bookings.user_id', $user_id);
		$this->db->group_by('bookings.booking_id');

		$query = $this->db->get();

		return $query->result();
	}
}

?>