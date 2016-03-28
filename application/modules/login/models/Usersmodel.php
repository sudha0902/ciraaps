<?php
class Usersmodel extends CI_Model{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getAllOrderBy($orderby)
	{
		$this->db->order_by($orderby);
		$result = $this->db->get("UserAccount");
		return $result;
	}
	
	public function getProfileByUuid($uuid)
	{
		$this->db->select('*');
		$this->db->from(array("UserAccount UA", "UserProfile UP"));
		$this->db->where("`UA`.`ua_uuid` = '$uuid' AND
		                       `UP`.`user_uuid` = `UA`.`ua_uuid`");
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
	
	public function setNewPwd($uuid, $newpwd)
	{
		$hash = create_hash($newpwd);
		$this->db->where('ua_uuid',$uuid);
		$result = $this->db->update('UserAccount',array('password' => $newpwd, 'changePassword' => 'N'));
		if (!$result)
		{
			$data['errno'] = $this->db-error_number();
			$data['errmsg'] = $this->db->error_message();
			$data['success'] = false;
		}
		else 
			$data['success'] = true;
		
		return $data;
    ;
	}
	public function getSecurityQuestion($username)
	{
		$sql = "SELECT * 
					FROM  UserAccount U,  LookupSecurityQuestions L
					WHERE  U.ua_SecQID =  L.SecQID 
					AND  U.Username =  '$username'";
		$result = $this->db->query($sql);
		return $result;
	}
			
	public function validate_userpwd($username, $password)
	{
		$this->db->where(array("Username" => $username, "UserStatus" => "active"));
		$result = $this->db->get("UserAccount");
		if ($result->num_rows() > 0){
			$row = $result->row();
			$hash = $row->Password;
			if(validate_password($password, $hash))
				$validuser = $row->ua_uuid;
		   else 
		   	$validuser = false;
		}
		else{
			$validuser = false;
		}
		return $validuser;	
	   	
		
	}
}