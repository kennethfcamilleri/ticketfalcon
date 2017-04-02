<?php

	class Users extends CI_Controller {


		public function signup() {

			$this->form_validation->set_rules('firstname','First Name','trim|required|min_length[3]');
			$this->form_validation->set_rules('lastname','Last Name','trim|required|min_length[3]');
			$this->form_validation->set_rules('email','Email','trim|required|min_length[3]');
			$this->form_validation->set_rules('password','Password','trim|required|min_length[3]');
			$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|min_length[3]|matches[password]');

			// If validation did not pass
			if ($this->form_validation->run() == False) {
				$data = array(
					'errors' => validation_errors()
					);

				$this->session->set_flashdata($data);

				redirect('users/signup_form');
			} // If validation is correct
			else { 
				if ($this->user_model->register_user()) {

					$this->session->set_flashdata('registered', 'Sign Up Completed!');
					redirect('home/index');
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
					'errors' => validation_errors()
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

				$this->session->set_flashdata('login_success','You have successfully logged in!');

				redirect('home/index');

				}
				else {

					$this->session->set_flashdata('login_failed','Failed to login!');

					redirect('home/index');
				}
			}
		}

		public function changepassword() {
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
						'errors' => validation_errors()
						);

					$this->session->set_flashdata($data);

					redirect('users/accountsettings#changepassword');
				} // If validation is correct
				else { 
					if ($this->user_model->update_password($newpassword,$user_id)) {

						$this->session->set_flashdata('password_updated', 'Your password has been succesfully updated!');
						redirect('users/accountsettings#changepassword');
					}
				}
			}
			else {
				$this->session->set_flashdata('password_error', 'Incorrect Password. Please try again!');
				redirect('users/accountsettings#changepassword');
			}


		}

		public function update() {

			$user_id = $this->session->userdata('user_id');

			$data = array(
				'first_name' => $this->input->post('firstname'),
				'last_name' => $this->input->post('lastname'),
				'email_address' => $this->input->post('email')
				);

			if ($this->user_model->update_user($data, $user_id)) {
				$this->session->set_flashdata('user_updated','Your details have been successfully updated!');

				redirect('users/accountsettings');
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

			$user_id = $this->session->userdata('user_id');

			$data['main_view'] = "bookinghistory_view";
			$data['userbookings'] = $this->user_model->get_userbookings($user_id);

			$this->load->view('layouts/main',$data);

		}

		public function accountsettings() {
			$data['user_details'] = $this->user_model->get_userdata($this->session->userdata('user_id'));

			$data['main_view'] = "accountsettings_view";

			$this->load->view('layouts/main',$data);
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

		// public function show() {
		// 	$data['result']  = $this->user_model->get_users();

		// 	$this->load->view('users_view',$data);
		// }

		// public function insert() {

		// 	$user_id = 3;
		// 	$first_name = "Deelan";
		// 	$last_name = "Sacco";
		// 	$email_address = "deelan.sacco@credorax.com";
		// 	$user_password = "12345";


		// 	$this->user_model->create_users([
		// 		'user_id' => $user_id,
		// 		'first_name' => $first_name,
		// 		'last_name' => $last_name,
		// 		'email_address' => $email_address,
		// 		'user_password' => $user_password

		// 		]);

		// }

		// public function update() {
		// 	$user_id = 3;
		// 	$first_name = "Deez";

		// 	$this->user_model->update_users([
		// 		'first_name' => $first_name
		// 		],$user_id);
		// }

		// public function delete() {
		// 	$user_id = 3;

		// 	$this->user_model->delete_user($user_id);
		// }
	}

?>