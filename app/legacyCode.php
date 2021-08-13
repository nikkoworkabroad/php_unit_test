<?php
namespace App;

class legacyCode
{ 
	private $db, $username, $password;

	public function __construct(\DB $db)
	{
		$this->db = $db;
	}

	public function setUsername($username)
	{
		$this->username = $username;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}
	
	public function newUser()
	{
		$this->db->insert($this->username, md5($this->password));
	}
	
	function DeleteUser ()
	{
		if ($this->UserExists())
		{
			$this->db->delete ($this->username);
		}
	}

	function ChangePassword ()
	{
		$this->db->update ($this->username,  md5($this->password));
	}

	function UserExists ()
	{
		$user = $this->db->get($this->username);
		return !empty($user);
	}

}
