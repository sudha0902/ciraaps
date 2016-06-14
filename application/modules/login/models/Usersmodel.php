<?php
class Usersmodel extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getAllOrderBy($orderby)
	{
		$this->db->order_by($orderby);
		$result = $this->db->get("user_auth");
		return $result;
	}
	
	public function getProfileByUuid($uuid)
	{
		$this->db->select('*');
		$this->db->from(array("user_auth UA", "user_profile UP"));
		$this->db->where("`UA`.`UUID` = '$uuid' AND
		                  `UP`.`UUID` = `UA`.`UUID`");
		$result = $this->db->get();
		if (!$result)
		{
			$data['errno'] = $this->db->error_number();
			$data['errmsg'] = $this->db->error_message();
			$data['success'] = false;
		}
		if ($result->num_rows() > 0)
		{
			$data['row'] = $result->row();
			$data['success'] = true;
		}
		else 
		{
			$data['success'] = false;
		}
		return $data;                                          
	}
	
	public function getUserName($fname, $lname,$email)
	{
		$this->db->select('UA.Username');
		$this->db->from(array("user_orofile UP", 'user_auth UA'));
		$this->db->where("`UP`.`first_name` = '$fname' AND
				`UP`.`last_name` = '$lname' AND 
	         `UA`.`email` = '$email' AND
				`UP`.`UUID` = `UA`.`UUID`");
		$result = $this->db->get();
		if (!$result)
		{
			$data['errno'] = $this->db->error_number();
			$data['errmsg'] = $this->db->error_message();
			$data['success'] = false;
		}
		if ($result->num_rows() === 1)
		{
			$data['username'] = $result->row()->Username;
			$data['success'] = true;
		}
		else if ($result->num_rows() === 0 )
		{
			$data['errmsg'] = "No rows found";
			$data['success'] = false;
		}
		else if ($result->num_rows() > 1 )
		{
			$data['errmsg'] = "Two or More Records found";
			$data['success'] = false;
		}
		return $data;
	}

	public function getProfileByUsername($username)
	{
		log_message("debug","***In ProfileUsername");
		$this->db->select('*');
		$this->db->from(array("user_auth UA", "user_orofile UP"));
		$this->db->where("`UA`.`Username` = '$username' AND
				            `UP`.`UUID` = `UA`.`UUID`");
		$result = $this->db->get();
		if (!$result)
		{
			log_message("debug","***Error in query");
			
			$data['errno'] = $this->db->error_number();
			$data['errmsg'] = $this->db->error_message();
			$data['success'] = false;
		}
		if ($result->num_rows() > 0)
		{
			log_message("debug","***Success in query");
				
			$data['row'] = $result->row();
			$data['success'] = true;
		}
		else
		{
			log_message("debug","***No rows query");
			$data['success'] = false;
			$data['errmsg'] = "No rows found";
		}
		return $data;
	}
	
	public function setNewPwd($uuid, $newpwd, $temp)
	{
		$hash = create_hash($newpwd);
		$this->db->where('UUID',$uuid);
		
		$result = $this->db->update('user_auth',array('password' => $hash, 'force_change' => $temp?True:False));
		if (!$result)
		{
			$data['errno'] = $this->db-error_number();
			$data['errmsg'] = $this->db->error_message();
			$data['success'] = false;
		}
		else 
			$data['success'] = true;
		
		return $data;
  	}
	public function getSecurityQuestions($username)
	{
		$username = mysql_real_escape_string($username);
		$ques_nos = $this->config->item("No_Of_SecQuestions", "Login_Setup");
		$fields = "UUID, username";
		$from = " FROM user_auth U";
		$where = " WHERE ";
	   for ($i = 1; $i <= $ques_nos; $i++){
			$fields .= ", U.security_ques$i as Qid$i,  L$i.sec_question as question$i, U.security_ans$i as answer$i";
			$from .= ", lookup_security_questions L$i";
			$where .= "U.security_ques$i = L$i.ID AND ";
		}
		$where .= "U.username = '$username'";
		$sql = "SELECT ".$fields. $from .$where;
		$result = $this->db->query($sql);
		return $result;
	}

	public function setSecurityQuestions($uuid, $data)
	{
		
		$this->db->where("UUID", $uuid);
		$result = $this->db->update("user_auth", $data);
		if (!$result)
		{	
				$data['errno'] = $this->db-error_number();
				$data['errmsg'] = $this->db->error_message();
				$data['success'] = false;
		}
		else{
				$data['success'] = true;
		}
		return $data;
	}
	public function validate_userpwd($username, $password)
	{
		$username = mysql_real_escape_string($username);
		$this->db->where(array("username" => $username, "user_status" => "1"));
		$result = $this->db->get("user_auth");
		if ($result->num_rows() > 0){
			$row = $result->row();
			$hash = $row->password;
			if(validate_password($password, $hash))
				$validuser = $row->UUID;
		   else 
		   	$validuser = false;
		}
		else{
			$validuser = false;
		}
		return $validuser;	
	   	
		
	}
}