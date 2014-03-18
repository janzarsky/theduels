<?php

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_model');
	}

	public function addplayers() {
		$html_header_data['title'] = 'Admin';
		$html_header_data['style'] = 'admin.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$admin_data['players'] = $this->admin_model->get_players();
		$admin_data['avatars'] = $this->admin_model->get_avatars();
		$this->load->view('admin/addplayers', $admin_data);
		
		$html_footer_data['script'] = 'addplayers.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
}