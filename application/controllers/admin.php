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
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			$html_header_data['title'] = 'Admin';
			$html_header_data['style'] = 'list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['header'] = 'Admin';
			$data['items'] = $this->admin_model->get_pages();
			$this->load->view('templates/list', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}

	public function players() {
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			$html_header_data['title'] = 'Správa hráčů';
			$html_header_data['styles'] = array('editable_list.css', 'admin__players_add.css');
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['header'] = 'Správa hráčů';
			$data['items'] = $this->admin_model->get_players();
			
			$add_data['avatars'] = $this->admin_model->get_free_avatars();
			$data['add'] = $this->load->view('admin/players_add', $add_data, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'admin/players_delete_submit';
			$data['delete'] = $this->load->view('templates/editable_list_delete', $delete_data, true);
			
			$this->load->view('templates/editable_list', $data);
			
			$html_footer_data['script'] = 'players.js';
			$this->load->view('templates/html_footer', $html_footer_data);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function players_add_submit() {
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			try {
				$this->admin_model->add_player($this->input->post('name'), $this->input->post('avatar_id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('admin/players', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function players_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			try {
				$this->admin_model->delete_player($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('admin/players', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function settings() {
		try {
			$this->ip_model->validate_ip();
			$this->check_lock();
			
			$html_header_data['title'] = 'Možnosti';
			$html_header_data['style'] = 'switch_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$this->load->view('templates/menu');
			
			$data['header'] = 'Možnosti:';
			$data['items'] = $this->admin_model->get_settings();
			$data['submit_url'] = 'admin/settings_submit';
			$this->load->view('templates/switch_list', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	private function check_lock() {
		if ($this->admin_model->get_setup_lock() == false)
			throw new Exception('You must lock setup first!');
	}
	
	private function redirect_with_message($url, $message) {
		if (isset($message) || $message != '')
			redirect(base_url($url) . '?message=' . $message);
		else
			redirect(base_url($url) . '?message=success');
	}
	
	private function show_error_page($error) {
		$html_header_data['title'] = 'Chyba';
		$html_header_data['style'] = 'error.css';
		$this->load->view('templates/html_header', $html_header_data);
		
		$this->load->view('templates/menu');
		
		$data['message'] = $error->getMessage();
		$this->load->view('templates/error', $data);
		
		$this->load->view('templates/html_footer');
	}
}