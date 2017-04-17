<?php

	class Users extends CI_Controller {


		public function signup() {

			$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[2]');
			$this->form_validation->set_rules('email','Email','trim|required');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[3]');
			$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|min_length[3]|matches[password]');

			// If validation did not pass
			if ($this->form_validation->run() == False) {
				$data = array(
					'error' => validation_errors()
					);

				$this->session->set_flashdata($data);

			} // If validation is correct
			else { 
				if ($this->user_model->register_user()) {

					$this->session->set_flashdata('success', 'Sign Up Complete. Please enter your credentials to login.');
					redirect('users/login_form');
				}
			}

			$data['main_view'] = 'signup_view';
			$this->load->view('layouts/main',$data);
		}

		public function login() {

			$this->form_validation->set_rules('username','Username','trim|required|min_length[3]');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[3]');

			// If validation did not pass
			if ($this->form_validation->run() == False) {
				$data = array(
					'error' => validation_errors()
					);

				$this->session->set_flashdata($data);

				redirect('users/login_form');
			} // If validation is correct
			else { 
				$username = $this->input->post('username');
				$password = $this->input->post('password');

				$user_id = $this->user_model->login_user($username,$password);				

				if ($user_id) {
					$fullname = $this->user_model->get_fullname($user_id);

					$userdata = array(
						'user_id' => $user_id,
						'username' => $username,
						'fullname' => $fullname,
						'logged_in' => true
						);

				$this->session->set_userdata($userdata);

				redirect('home/index');

				}
				else {
					$this->session->set_flashdata('error','Failed to login!');
					redirect('users/login_form');
				}
			}
		}

		public function update_password() {
			$currentpassword = $this->input->post('currentpassword');
			$newpassword = $this->input->post('newpassword');
			$confirmpassword = $this->input->post('confirmpassword');

			$user_id = $this->session->userdata('user_id');

			if ($this->user_model->verify_password($currentpassword,$user_id)) {
				$this->form_validation->set_rules('currentpassword','Current Password','trim|required|min_length[3]');
				$this->form_validation->set_rules('newpassword','New Password','trim|required|min_length[3]');
				$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|min_length[3]|matches[newpassword]');

				// If validation did not pass
				if ($this->form_validation->run() == False) {
					$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>'); 
					$data = array(
						'error' => validation_errors()
						);

					$this->session->set_flashdata($data);

					redirect('users/changepassword');
				} // If validation is correct
				else { 
					if ($this->user_model->update_password($newpassword,$user_id)) {

						$this->session->set_flashdata('success', 'Your password has been succesfully updated!');
						redirect('users/changepassword');
					}
				}
			}
			else {
				$this->session->set_flashdata('error', 'Incorrect Password. Please try again!');
				redirect('users/changepassword');
			}

		}

		public function update_contact_info() {

			$user_id = $this->session->userdata('user_id');

			$data = array(
				'first_name' => $this->input->post('firstname',true),
				'last_name' => $this->input->post('lastname',true),
				'email_address' => $this->input->post('email')
				);

			if ($this->user_model->update_user($data, $user_id)) {

				$fullname = $this->user_model->get_fullname($user_id);
				$username = $this->input->post('email');

				$this->session->set_userdata('username', $username);
				$this->session->set_userdata('fullname', $fullname);

				$this->session->set_flashdata('success','Your details have been successfully updated!');

				redirect('users/contactinfo');
			}
		}

		public function bookingdetails($booking_id) {
			$user_id = $this->session->userdata('user_id');

			$data['booking'] = $this->user_model->get_booking($booking_id);
			$data['bookinglines'] = $this->user_model->get_bookinglines($booking_id);

			$data['main_view'] = "bookingdetails_view";

			$this->load->view('layouts/main',$data);
		}

		public function bookinghistory() {

			if ($this->session->userdata('logged_in')) {
				$user_id = $this->session->userdata('user_id');

				$data['main_view'] = "bookinghistory_view";
				$data['userbookings'] = $this->user_model->get_userbookings($user_id);

				$this->load->view('layouts/main',$data);
			}
			else {
				redirect('users/login_form');
			}


		}

		public function changepassword() {
			if ($this->session->userdata('logged_in')) {

				$data['main_view'] = "changepassword_view";

				$this->load->view('layouts/main',$data);
			}
			else {
				redirect('users/login_form');
			}
		}

		public function contactinfo() {
			if ($this->session->userdata('logged_in')) {
				$data['user_details'] = $this->user_model->get_userdata($this->session->userdata('user_id'));

				$data['main_view'] = "contactinfo_view";

				$this->load->view('layouts/main',$data);
			}
			else {
				redirect('users/login_form');
			}
		}

		public function logout() {
			$this->session->sess_destroy();

			redirect('home/index');
		}

		public function login_form() {
			$data['main_view'] = "login_view";
			$this->load->view('layouts/main',$data);
		}

		public function signup_form() {
			$data['main_view'] = "signup_view";
			$this->load->view('layouts/main',$data);
		}
	}

?>