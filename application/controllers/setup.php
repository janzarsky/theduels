<?php

class Setup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('setup_model');
		$this->load->model('ip_model');
	}
	
	public function index() {
		try {
			$this->ip_model->validate_ip();
			
			$html_header_data['title'] = 'Nastavení';
			$html_header_data['style'] = 'setup.css';
			$this->load->view('templates/html_header', $html_header_data);
			
			$data['items'] = $this->setup_model->get_pages();
			$data['locked'] = false;
			$this->load->view('setup/index', $data);
			
			$this->load->view('templates/html_footer');
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
			$data['items'] = $this->setup_model->get_ips();
			
			$data['add'] = $this->load->view('setup/whitelist_add', null, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'setup/whitelist_delete_submit';
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
				$this->setup_model->add_ip($this->input->post('ip'), $this->input->post('name'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/whitelist', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function whitelist_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->setup_model->delete_ip($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/whitelist', $message);
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
			$data['items'] = $this->setup_model->get_skills_as_items();
			
			$data['add'] = $this->load->view('setup/skills_add', null, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'setup/skills_delete_submit';
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
				$this->setup_model->add_skill($this->input->post('name'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/skills', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function skills_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->setup_model->delete_skill($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/skills', $message);
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
			$data['items'] = $this->setup_model->get_games();
			
			$add_data['skills'] = $this->setup_model->get_skills();
			$data['add'] = $this->load->view('setup/games_add', $add_data, true);
			
			$delete_data['items'] = $data['items'];
			$delete_data['submit_url'] = 'setup/games_delete_submit';
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
				$this->setup_model->add_game($this->input->post('name'), $this->input->post('skill_id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/games', $message);
		}
		catch (Exception $e) {
			$this->show_error_page($e);
		}
	}
	
	public function games_delete_submit() {
		try {
			$this->ip_model->validate_ip();
			
			try {
				$this->setup_model->delete_game($this->input->post('id'));
			}
			catch (Exception $e) {
				$message .= $e->getMessage();
			}
			
			$this->redirect_with_message('setup/games', $message);
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