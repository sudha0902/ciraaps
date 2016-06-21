<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	
  	
	public function __Construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->config('auth_config');
		$this->load->library(array('session', 'form_validation'));
		$this->load->helper(array('url','language','PasswordHash', 'base_helper'));
		$this->load->model('usersmodel');
		$this->form_validation->set_error_delimiters($this->config->item('<div class="alert alert-danger">', '</div>'));
	}
	
	/**
	 * 
	 */
	public function index()
	{
		//$uuid = "p4c_38e65ce1-1882-11e6-8fbd-a0d3c1985d91";
		//redirect("/login/setSecurityQuestion/$uuid");
		if ($this->input->post())
		{
  	  		$username = strtolower(trim($this->input->post('username', true)));
			$pwd = trim($this->input->post('pwd', true));
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
		else{ 
			$data = array();
		}
		$data['login_setup'] = $this->config->item('Login_Setup');
		$this->load->view('view_login', $data);
	
	}
	public function forgotUserName()
	{
		
		if ($this->input->post())
		{
			$fname = trim($this->input->post('fname', true));
			$lname = trim($this->input->post('lname', true));
			$email = trim($this->input->post('email', true));
			$result = $this->usersmodel->getUserName($fname, $lname, $email);	
			if ($result['success'])
			{
				$username = $result['username'];
				$success = $this->_send_username_email($email,$username);
				if ($success){
					$data['message'] = "Your Username has been sent to your Email"; 
			   	$data['success'] = true;
				}
			   else {
			   	$data['message'] = "Error Sending Email";
			   	$data['success'] = false;
			   }
 			}	
 			else 
 			{
 				$data['message'] = $result['errmsg'];
 				$data['success'] = false;
 			}
 			header("Content-Type : application/json");
 			echo json_encode($data);
 			die();
		}
		else
		{
			$this->load->view("view_forgotUser");
		}
		
	}
	public function forgotPwd()
	{
			if ($this->config->item('Pwd_Retrieval_Method', 'Login_Setup') === "SecQuestion")
			{
				redirect("/login/lostpwd1");
			}
		   if ($this->config->item('Pwd_Retrieval_Method','Login_Setup') === "Email") 
		   {
		   	redirect("/login/lostpwd2");
		   }
	}
	
	public function lostpwd1()
	{
		if ($this->input->post())
		{
	   	//  get ajax call params
 		  	$action = $this->input->post('action', true);
		  	$username = strtolower(trim($this->input->post('userName', true)));
		  	if ($action == "getSecurityQuestions")	
		  	{	  	
		  		$qryresult = $this->usersmodel->getSecurityQuestions($username);
				if ($qryresult->num_rows() == 1){
		  			$data['success'] = true;
		  			$row = $qryresult->row();
		  			$noOfQuestions = $this->config->item("No_Of_SecQuestions","Login_Setup");
		  			for ($i = 1; $i <= $noOfQuestions; $i++)
		  			{
		  				$qfield = "question$i";
		  				$afield = "answer$i"	;		
		  				$data["question$i"] = $row->$qfield;
		  				$data["answer$i"] = $row->$afield;
		  			}
		  		}
		  		else {
		  			$data['success'] = false;
		  		}
		  		header("Content-Type : application/json");
		 		echo json_encode($data);
		  		die();
		  	}
		  	if ($action == "verifySecurityAnswers")
		  	{
		  		$noOfQuestions = $this->config->item("No_Of_SecQuestions","Login_Setup");
		  		for ($i = 1; $i <= $noOfQuestions; $i++)
		  		{
		  			$var = "answer".$i;
		  			$$var = $this->input->post("answer".$i, true);
		  			
		  		}
		  		$qryresult = $this->usersmodel->getSecurityQuestions($username);
		  		if ($qryresult->num_rows() == 1){
		  			$row = $qryresult->row();
		  			$uuid = $row->UUID;
		  			$condition = true;
		  			for ($i = 1; $i <= $noOfQuestions; $i++)
		  			{
		  				$var = "answer".$i;
		  				//$condition =  $condition && ($$var === $row->$var);
		  				$condition = $condition && validate_password($$var, $row->$var);
											  	  			
		  			}
		  			if ($condition){
		  				$data['success'] = true;
		  				$data['url'] = "/login/resetpwd/$uuid";
		  			}
		  			else {
		  				$data['success'] = false;
		  			}
		  		}
		  		else {
		  			$data['success'] = false;
		  		}
		  		header("Content-Type : application/json");
		 		echo json_encode($data);
		  		die();
		  	}
		}
		$data['noOfQuestions'] = $this->config->item("No_Of_SecQuestions","Login_Setup");
		$this->load->view('view_lostpwd',$data);
	}

	public function lostpwd2()
	{
		$this->load->view('view_lostpwd2');
	}	
	
	public function generateTemporaryPwd()
	{
		if ($this->input->post())
		{
			//  get ajax call params
			$username = strtolower(trim($this->input->post('username', true)));
			$email = $this->input->post('email', true);
			log_message('debug', print_r($username, true));
			log_message('debug', print_r($email, true));
				
			$result = $this->usersmodel->getProfileByUsername($username);
			log_message('debug', print_r($result, true));
			if (isset($result['row']))
			{
				if ($result['row']->Email === $email)
				{
					$token = getToken(8);
					$uuid = $result['row']->ua_uuid;
					$success = $this->_send_recovery_email($email,$token);
					if ($success){
						$result= $this->usersmodel->setNewpwd($uuid, $token, true);
						if($result['success']) {
							$data['success'] = true;
				  			$data['message'] = "Please Login with the temporary password sent to $email";
						}
						else {
					  		$data['success'] = false;
				 	  		$data['message'] = "An Error Occured, Cannot Reset Password";
						}
					}
					else 
					{
						$data['success'] = false;
						$data['message'] = "Error Sending Email";
					}
				}
				else {
					$data['success'] = false;
					$data['message'] = "Invalid Username and Email Combination";
				}
			}
			else {
				$data['success'] = false;
				$data['message'] = $result['errmsg'];
			}
		}
		header("Content-Type : application/json");
		echo json_encode($data);
		die();
	}
	
	private function _send_recovery_email($user_email, $key) {
		$domain =  $this->config->slash_item('base_url');
		$this->load->library('email');
		$this->email->from('webmaster@' . $domain, 'Password Reset');
		$this->email->to($user_email);
		$this->email->subject('Temporary Password Email');
		$this->email->message("<p> Your New Temporary Password is <b> $key </b>.</p> 
				                 <p> Please login using your new  temporary password
		                           You will be prompted to change your password when you login");
		$result = $this->email->send();
		return $result;
	}
	
	private function _send_username_email($user_email, $name) {
		$domain =  $this->config->slash_item('base_url');
		$this->load->library('email');
		$this->email->from('webmaster@' . $domain, 'Username Recovery');
		$this->email->to($user_email);
		$this->email->subject('UserName Recovery Email');
		$this->email->message("<p> Your UserName is<b>". $name ."</b>.</p>
				<p> Please login using your username. </p>
				If you don't remember your password, please choose the 'Forgot Password' link to recover your password");
		$result = $this->email->send();
		return $result;
	}
	public function resetpwd($uuid)
	{
		if ($this->input->post())
		{
			log_message('debug', "Post is not empty");
			$newpasswd = $this->input->post('newPwd');
			log_message('debug', "newpwd is $newpasswd");
			$this->load->helper("PasswordHash");
			$data= $this->usersmodel->setNewpwd($uuid, $newpasswd, false);
			if ($data['success'])
			{
					$data['url'] = site_url("login/_login/$uuid");
				
			}
			header("Content-Type : application/json");
			echo json_encode($data);
			die();
			
		}
		$data['uuid'] = $uuid;
		$this->load->view('view_resetpwd', $data);
		
	}


	public function _login($uuid)
	{
		$data = $this->usersmodel->getProfileByUuid($uuid);
		if (!$data['success'] && isset($data['errno'])){
			log_message("error", $data['errmsg']);
			die();
		}
		if (isset($data['row']))
		{
			if ($data['row']->force_change === "Y")
				$this->lostpwd($uuid);
			if ($data['row']->security_ques1 === NULL)
				redirect("/login/setSecurityQuestion/$uuid");
			$this->load->model("Groupsmodel");
			$group_name = $this->Groupsmodel->get_name($data['row']->user_group_id);
			$this->_store_session_vars($data);
       	log_message("debug", "Redirecting to Dashboard $top_page");
        	$top_page = $this->Groupsmodel->get_top_page($data['row']->user_group_id);
        	if ($top_page)
       		redirect(site_url("dashboard/$top_page"));
        	else 
        		$this->load->view('error_404');
		
		}
	}
	public function _store_session_vars($data)
	{
		log_message("debug", "Init Session");
		$user_info = array( 'MM_UUID'=> $data['row']->UUID ,
				'MM_Username'=> $data['row']->username ,
				'MM_Usergroup'=> $data['row']->user_group_id ,
				'MM_Group' => $group_name,
				'MM_ClientID'=> $data['row']->client_id ,
				'MM_ClientCode'=> $data['row']->client_loc ,
				'MM_FirstName'=> $data['row']->first_name ,
				'MM_LastName'=> $data['row']->last_name ,
				'MM_UserEmail'=> $data['row']->email ) ;
		$this->session->set_userdata($user_info);
		log_message("debug", print_r( $this->session->all_userdata(),true));
		return;
	}
	public function register()
	{
		$this->load->view('view_register');
		
	}
	
	public function setSecurityQuestion($uuid)
	{
		if ($this->input->post())
		{
			log_message('debug', "*****Post is not empty*****");
			log_message('debug', print_r($this->input->post(), true));
			$noofques = $this->config->item("No_Of_SecQuestions","Login_Setup");
			$data = array();
			for ($i = 1; $i <= $noofques; $i++)
			{	
				$data["security_ques$i"] = $this->input->post("question$i", true);
	      	$data["security_ans$i"] = create_hash($this->input->post("answer$i", true));
			
			}
			$result = $this->usersmodel->setSecurityQuestions($uuid, $data);
			if ($result['success'])
				$this->_login($uuid);
		}
		else
		{
			$viewdata = array();
			$secQuestions = array();
			$questions = $this->db->get("my_lookup_security_questions");
			foreach ($questions->result() as $row)
			{
				array_push($secQuestions, $row);
			}
			$viewdata['uuid'] = $uuid;
			$viewdata['noOfQuestions'] = $this->config->item("No_Of_SecQuestions","Login_Setup");
			$viewdata['secQuestions'] = $secQuestions ;
			$this->load->view('view_securityquestions', $viewdata);
		}
	}
	function logout() {
		$this->session->sess_destroy();
		redirect(site_url('/login'));
	}
}