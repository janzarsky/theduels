<?php

class Overview extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('overview_model');
	}

	public function index() {
		try {
			if ($this->overview_model->is_position_visible() == false)
				throw new Exception('Zobrazení pořadí zakázáno');
			
			$html_header_data['title'] = 'Přehled';
			$html_header_data['style'] = 'overview.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$overview_data['players'] = $this->overview_model->get_players();
			$this->load->view('overview/index', $overview_data);
			
			$html_footer_data['script'] = 'overview.js';
			$this->load->view('templates/html_footer', $html_footer_data);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function data() {
		try {
			if ($this->overview_model->is_position_visible() == false)
				throw new Exception('Zobrazení pořadí zakázáno');
			
			if ($this->input->get('w') !== false && $this->input->get('h') !== false)
				$data['json_object'] = $this->overview_model->get_data($this->input->get('w'), $this->input->get('h'));
			else
				$data['json_object'] = $this->overview_model->get_data();
			
			$this->load->view('templates/json', $data);
		}
		catch (Exception $e) {
			echo "";
		}
	}
	
	private function show_error_page($error) {
		$html_header_data['title'] = 'Chyba';
		$html_header_data['style'] = 'error.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$data['message'] = $error->getMessage();
		$this->load->view('templates/error', $data);
		
		$this->load->view('templates/html_footer');
	}
}