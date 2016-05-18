<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/*  just testing
	public function userlist()
	{
		$this->load->model('usersmodel');
		$data['qresult'] = $this->usersmodel->getAllOrderBy('Username');
		$this->load->view('users_list', $data);
	}
	*/
	public function index()
	{
		$data = array();
		if ($this->input->post())
		{
  	  		$username = $this->input->post('username');
			$pwd = $this->input->post('pwd');
			$CI =& get_instance();
			$CI->load->helper("PasswordHash");
			$this->load->model('usersmodel');
			$valid_uuid = $this->usersmodel->validate_userpwd($username, $pwd);
			
			if (!$valid_uuid){
				$data['username'] = $username;
				$data['pwd'] = $pwd;
				$data['errmsg'] = "Invalid User Name or Password";
			}
			else 
			{
				$this->_login($valid_uuid);
			}
		}
		$this->load->view('view_login', $data);
	
	}
	public function lostpwd()
	{
		   if ($this->input->post()){

		   	//  get ajax call params
 		   	$action = $this->input->post('action', true);
		   	$username = $this->input->post('userName', true);
		   	if (($this->input->post('answer'))){
		   		$answer = strtolower( $this->input->post('answer', true));
		   		$data['answer'] = $answer;
		   	}
		   	
		   	$this->load->model('usersmodel');
				$qryresult = $this->usersmodel->$action($username);
				//$data['num_rows'] = $qryresult->num_rows();
				//$data['result'] = $qryresult;
		   	if ($qryresult->num_rows() >0){
		   		$data['success'] = true;
		   		$data['question'] = $qryresult->row()->SecQuestion;
		   		if (isset($answer))
		   		{
		   			if ($answer === strtolower($qryresult->row()->ua_SecAnswer)){	
              			$data['success'] = true;
							//$this->load->helper('SessionStart');
		   				//initialize_session($username);
							$uuid = $qryresult->row()->ua_uuid;
              			$data['url'] = "/login/resetpwd/$uuid";
		   			}
		   			else{
		   				$data['success'] = false;
		   			}
		   			
		   		}
		   	}
		   	else {
		   		$data['success'] = false;
		   	}
		  		header("Content-Type : application/json");
		   	echo json_encode($data);
		   	die();
		   }
			$this->load->view('view_lostpwd');
	
	}
	
	
	public function resetpwd($uuid)
	{
		$data['uuid'] = $uuid;
		if ($this->input->post())
		{
			log_message('debug', "Post is not empty");
			$newpasswd = $this->input->post('newPwd');
			log_message('debug', "newpwd is $newpasswd");
			$this->load->helper("PasswordHash");
			$this->load->model('usersmodel');
			$data= $this->usersmodel->setNewpwd($uuid, $newpasswd);
			if ($data['success'])
			{
				$this->_login($uuid);
			}
		}			
		$this->load->view('view_resetpwd', $data);
	}


	private function _login($uuid)
	{
		$this->load->model('usersmodel') ;
		$data = $this->usersmodel->getProfileByUuid($uuid);
		if (!$data['success'] && isset($data['errno'])){
			log_message("error", $data['errmsg']);
			die();
		}
		if (isset($data['row']))
		{
			if ($data['row']->changePassword === "Y")
				$this->lostpwd($uuid);
			if ($data['row']->ua_SecQID === NULL)
				redirect("/login/setSecurityQuestion/$uuid");
			
			log_message("debug", "Init Session");
			$_SESSION['MM_UserID'] = $data['row']->UserID;
			$_SESSION['MM_UUID'] = $data['row']->ua_uuid;
			$_SESSION['MM_Username'] = $data['row']->Username;
			$_SESSION['MM_Userrole'] = $data['row']->Role;
			$_SESSION['MM_ClientID'] = $data['row']->ClientID;
			$_SESSION['MM_ClientCode'] = $data['row']->clientCode;
		   $_SESSION['MM_FirstName'] = $data['row']->FirstName;
         $_SESSION['MM_LastName'] = $data['row']->LastName;
        	$_SESSION['MM_UserEmail'] = $data['row']->Email;
        	log_message("debug", "Redirecting to Dashboard");
       	redirect('/dashboard');
		}
        
	}
	private function register()
	{
		
	}
	
	public function setSecurityQuestion($uuid)
	{
		if ($this->input->post())
		{
			log_message('debug', "*****Post is not empty*****");
			log_message('debug', print_r($this->input->post(), true));
			$data = array('ua_SecQID' => $this->input->post('question'),
			              'ua_SecAnswer' => $this->input->post('answer'));
			$this->db->where("ua_uuid", $uuid);
			$this->db->update("UserAccount", $data);
			$this->_login($uuid);
		}
		else
		{
			$viewdata = array();
			$secQuestions = array();
			$questions = $this->db->get("LookupSecurityQuestions");
			
			foreach ($questions->result() as $row)
			{
				array_push($secQuestions, $row);
			}
			$viewdata['uuid'] = $uuid;
			$viewdata['secQuestions'] = $secQuestions ;
			$this->load->view('view_securityquestions', $viewdata);
		}
		
	}
}