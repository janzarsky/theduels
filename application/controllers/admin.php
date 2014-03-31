<?php

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('admin_model');
		$this->load->model('ip_model');
	}

	public function index() {
		$html_header_data['title'] = 'Admin';
		$html_header_data['style'] = 'list.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$list_data['header'] = 'Admin';
		$list_data['items'] = $this->admin_model->get_pages();
		$this->load->view('templates/list', $list_data);
		
		$this->load->view('templates/html_footer');
	}

	public function addplayers() {
		$html_header_data['title'] = 'Správa hráčů';
		$html_header_data['style'] = 'admin_addplayers.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$admin_data['players'] = $this->admin_model->get_players();
		$admin_data['avatars'] = $this->admin_model->get_free_avatars();
		$this->load->view('admin/addplayers', $admin_data);
		
		$html_footer_data['script'] = 'addplayers.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
	
	public function addplayers_submit() {
		try {
			if ($this->ip_model->is_ip_valid($this->input->server('REMOTE_ADDR')) == false)
				throw new Exception('Invalid ip address ' . $this->input->server('REMOTE_ADDR'));
			
			$this->admin_model->add_player($this->input->post('name'), $this->input->post('avatar_id'));
		}
		catch (Exception $e) {
			$message .= $e->getMessage();
		}
		
		if (isset($message))
			redirect('admin/addplayers?message=' . $message);
		else
			redirect('admin/addplayers?message=success');
	}
	
	public function deleteplayers_submit() {
		try {
			if ($this->ip_model->is_ip_valid($this->input->server('REMOTE_ADDR')) == false)
				throw new Exception('Invalid ip address ' . $this->input->server('REMOTE_ADDR'));
			
			$this->admin_model->delete_player($this->input->post('id'));
		}
		catch (Exception $e) {
			$message .= $e->getMessage();
		}
		
		if (isset($message))
			redirect('admin/addplayers?message=' . $message);
		else
			redirect('admin/addplayers?message=success');
	}
}