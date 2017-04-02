<?php

	class Home extends CI_Controller {

		public function index()
		{
			$data['recent_events'] = $this->event_model->get_recently_added_events();
			$data['main_view'] = "home_view";
			$this->load->view('layouts/main',$data);
		}
	}
?>