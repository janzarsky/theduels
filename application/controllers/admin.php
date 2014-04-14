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
			
			$html_header_data['title'] = 'Admin';
			$html_header_data['style'] = 'list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$list_data['header'] = 'Admin';
			$list_data['items'] = $this->admin_model->get_pages();
			$this->load->view('templates/list', $list_data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}

	public function players() {
		try {
			$this->ip_model->validate_ip();
			
			$html_header_data['title'] = 'Správa hráčů';
			$html_header_data['styles'] = array('editable_list.css', 'admin__players_add.css');
			$this->load->view('templates/html_header', $html_header_data);
			
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
	
	public function whitelist() {
		try {
			$this->ip_model->validate_ip();
			
			$html_header_data['title'] = 'IP whitelist';
			$html_header_data['style'] = 'editable_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$data['header'] = 'Povolené IP adresy:';
			$data['items'] = $this->admin_model->get_ips();
			
			$data['add'] = $this->load->view('admin/whitelist_add', null, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'admin/whitelist_delete_submit';
			$data['delete'] = $this->load->view('templates/editable_list_delete', $delete_data, true);
			
			$this->load->view('templates/editable_list', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function whitelist_add_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->admin_model->add_ip($this->input->post('ip'), $this->input->post('name'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('admin/whitelist', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function whitelist_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->admin_model->delete_ip($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('admin/whitelist', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games() {
		try {
			$this->ip_model->validate_ip();
			
			$html_header_data['title'] = 'Hry';
			$html_header_data['style'] = 'editable_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$data['header'] = 'Hry:';
			$data['items'] = $this->admin_model->get_games();
			
			$add_data['skills'] = $this->admin_model->get_skills();
			$data['add'] = $this->load->view('admin/games_add', $add_data, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'admin/games_delete_submit';
			$data['delete'] = $this->load->view('templates/editable_list_delete', $delete_data, true);
			
			$this->load->view('templates/editable_list', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games_add_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->admin_model->add_game($this->input->post('name'), $this->input->post('skill_id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('admin/games', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->admin_model->delete_game($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('admin/games', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills() {
		try {
			$this->ip_model->validate_ip();
			
			$html_header_data['title'] = 'Skilly';
			$html_header_data['style'] = 'editable_list.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$data['header'] = 'Skilly:';
			$data['items'] = $this->admin_model->get_skills_as_items();
			
			$data['add'] = $this->load->view('admin/skills_add', null, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'admin/skills_delete_submit';
			$data['delete'] = $this->load->view('templates/editable_list_delete', $delete_data, true);
			
			$this->load->view('templates/editable_list', $data);
			
			$this->load->view('templates/html_footer');
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills_add_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->admin_model->add_skill($this->input->post('name'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('admin/skills', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->admin_model->delete_skill($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('admin/skills', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
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
		
		$data['message'] = $error->getMessage();
		$this->load->view('templates/error', $data);
		
		$this->load->view('templates/html_footer');
	}
}