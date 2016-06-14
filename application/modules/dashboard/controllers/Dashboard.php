<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
	{
		
		if (!is_loggedin()) {
			redirect(site_url('/login'));
		}
		$this->load->model("RolesModel");
	}

	public function index()
	{
		
				
		
	}
}	