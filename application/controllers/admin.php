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

	public function players() {
		$html_header_data['title'] = 'Správa hráčů';
		$html_header_data['style'] = 'editable_list.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$data['header'] = 'Správa hráčů';
		$data['items'] = $this->admin_model->get_players();
		
		$add_data['avatars'] = $this->admin_model->get_free_avatars();
		$data['add'] = $this->load->view('admin/players_add', $add_data, true);
		
		$delete_data['items'] = $data['items'];
		$data['delete'] = $this->load->view('admin/players_delete', $delete_data, true);
		
		$this->load->view('templates/editable_list', $data);
		
		$html_footer_data['script'] = 'players.js';
		$this->load->view('templates/html_footer', $html_footer_data);
	}
	
	public function players_add_submit() {
		try {
			if ($this->ip_model->is_ip_valid($this->input->server('REMOTE_ADDR')) == false)
				throw new Exception('Invalid ip address ' . $this->input->server('REMOTE_ADDR'));
			
			$this->admin_model->add_player($this->input->post('name'), $this->input->post('avatar_id'));
		}
		catch (Exception $e) {
			$message .= $e->getMessage();
		}
		
		if (isset($message))
			redirect('admin/players?message=' . $message);
		else
			redirect('admin/players?message=success');
	}
	
	public function players_delete_submit() {
		try {
			if ($this->ip_model->is_ip_valid($this->input->server('REMOTE_ADDR')) == false)
				throw new Exception('Invalid ip address ' . $this->input->server('REMOTE_ADDR'));
			
			$this->admin_model->delete_player($this->input->post('id'));
		}
		catch (Exception $e) {
			$message .= $e->getMessage();
		}
		
		if (isset($message))
			redirect('admin/players?message=' . $message);
		else
			redirect('admin/players?message=success');
	}
	
	public function whitelist() {
		$html_header_data['title'] = 'IP whitelist';
		$html_header_data['style'] = 'editable_list.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$data['header'] = 'Povolené IP adresy:';
		$data['items'] = $this->admin_model->get_ips();
		
		$data['add'] = $this->load->view('admin/whitelist_add', null, true);
		
		$delete_data['items'] = $data['items'];
		$data['delete'] = $this->load->view('admin/whitelist_delete', $delete_data, true);
		
		$this->load->view('templates/editable_list', $data);
		
		$this->load->view('templates/html_footer');
	}
	
	public function whitelist_add_submit() {
		try {
			if ($this->ip_model->is_ip_valid($this->input->server('REMOTE_ADDR')) == false)
				throw new Exception('Invalid ip address ' . $this->input->server('REMOTE_ADDR'));
			
			$this->admin_model->add_ip($this->input->post('ip'), $this->input->post('name'));
		}
		catch (Exception $e) {
			$message .= $e->getMessage();
		}
		
		if (isset($message))
			redirect('admin/whitelist?message=' . $message);
		else
			redirect('admin/whitelist?message=success');
	}
	
	public function whitelist_delete_submit() {
		try {
			if ($this->ip_model->is_ip_valid($this->input->server('REMOTE_ADDR')) == false)
				throw new Exception('Invalid ip address ' . $this->input->server('REMOTE_ADDR'));
			
			$this->admin_model->delete_ip($this->input->post('id'));
		}
		catch (Exception $e) {
			$message .= $e->getMessage();
		}
		
		if (isset($message))
			redirect('admin/whitelist?message=' . $message);
		else
			redirect('admin/whitelist?message=success');
	}
}