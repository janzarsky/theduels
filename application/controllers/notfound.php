<?php

class NotFound extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index() {
		$html_header_data['title'] = 'Chyba';
		$html_header_data['style'] = 'error.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$data['message'] = 'Stránka nenalezena';
		$this->load->view('templates/error', $data);
		
		$this->load->view('templates/html_footer');
	}
}