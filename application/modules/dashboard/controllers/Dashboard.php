<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{
		$this->load->view("header_view");
		$this->load(view('leftsidebarmenu'));
		
	/*switch ($_SESSION['MM_Userrole'])
		{
			case 'Clinician':
			case 'SysAdmin':
			case 'Student'
		}*/
		//Echo "In Dashboard index controller";
	}
}	