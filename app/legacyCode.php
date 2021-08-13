<?php
namespace App;

class legacyCode
{ 
	private $db, $username, $password;

	/**
	 * Initialize DB class
	 *
	 * @param \DB $db
	 */
	public function __construct(\DB $db)
	{
		$this->db = $db;
	}

	/**
	 * Set Username
	 *
	 * @param [type] $string
	 * @return username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * Set Username
	 *
	 * @param [type] $string
	 * @return password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * Simulate Adding of user
	 *
	 * @return void
	 */
	public function newUser()
	{
		$this->db->insert($this->username, md5($this->password));
	}
	
	/**
	 * Simulate Deleting of user
	 *
	 * @return void
	 */
	function DeleteUser ()
	{
		if ($this->UserExists())
		{
			$this->db->delete ($this->username);
		}
	}

	/**
	 * Simulate User Change Password
	 *
	 * @return void
	 */
	function ChangePassword ()
	{
		$this->db->update ($this->username,  md5($this->password));
	}

	/**
	 * Simulate Checking if user exist
	 *
	 * @return !empty
	 */
	function UserExists ()
	{
		$user = $this->db->get($this->username);
		return !empty($user);
	}

}
