<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$view = $this->load->view("view_loggedin");
		$this->set_output($view);
	}
}	