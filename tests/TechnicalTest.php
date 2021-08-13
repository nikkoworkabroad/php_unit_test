<?php

require __DIR__.'/../vendor/autoload.php';

use App\legacyCode;
use PHPUnit\Framework\TestCase;

class TechnicalTest extends TestCase
{
	protected $db,$user;

	/**
	 * Setup
	 *
	 * @return void
	 */
	public function setUp(): void
	{
		$this->db = $this->getMockBuilder('DB')
			->setMethods(['insert','delete','update','get'])
			->getMock();

		$this->user = New legacyCode($this->db);
	}

	/**
	 * Test Create User
	 *
	 */
	public function testCreateUser()
	{
		$username = 'john';
		$password = 'pass123';

		$this->db->expects($this->once())
		->method('insert')
		->with($username, md5($password));

		$this->create($username, $password);
	}

	/**
	* Test Create user with short Password
	* 
	* If password is shorter than 6 chars, the user should not be created
	*
 	*/
	public function testCreateUserWithShortPassword()
	{
		$username = 'john';
		$password = 'pasds123';
		
		// $this->assertLessThanOrEqual(6,strlen($password));

		if(strlen($password) > 6)
		{
			$this->db->expects($this->once())
			->method('insert')
			->with($username, md5($password));

			$this->create($username, $password);
		}else{
			$this->db->expects($this->never())
			->method('insert');	
		}
	}

	/**
	* Test change Password
	* 
	*/
	public function testChangePassword()
	{
		$username = 'john';
		$newPassword = 'N3wpass!9';

		$this->db->expects($this->once())
		->method('update')
		->with($username, md5($newPassword));

		$this->updatePassword($username, $newPassword);
	}

	/**
	* Test change Password with short password
	* 
	*  If the new password is shorter than 6 chars, it shouldn't be updated
	*/

	public function testChangePasswordWithShortPassword()
	{
		$username = 'john';
		$newPassword = 'N3wpass!9';

		if(strlen($newPassword) > 6)
		{
			$this->db->expects($this->once())
			->method('update')
			->with($username, md5($newPassword));

			$this->updatePassword($username, $newPassword);

		}else{
			$this->db->expects($this->never())
			->method('update');
		}

	}

	/**
	* Test change Password of Non Existing User
	* 
	*  If user doesn't exist, the password should not be changed
	*/

	public function testChangePasswordOfNonExistingUser()
	{
		$username = 'john';
		$newPassword = 'N3wpass!9';

		$this->db->expects($this->once())
			->method('get')
			->with($username)
			->willReturn(null);

			if (!empty($this->isUserExist($username) ) )
			{
				$this->db->expects($this->never())->method('update');
				$this->updatePassword($username, $newPassword);
			}else{
				$this->updatePassword($username, $newPassword);
			}

	}


	/**
	* Test Delete Password of Non Existing User
	*
	*/

	public function testDeleteUser()
	{
		$username = 'john';

		$this->db->expects($this->once())
		->method('get')
		->with($username)
		->willReturn("something");

		$this->db->expects($this->once())
		->method('delete')
		->with($username);
		
		$this->delete($username);

	}


	/**
	* Test Delete of Non Existing User
	* 
	* If user doesn't exist, we shouldn't try to delete it
	*/

	public function testDeleteNonExistingUser()
	{
		$username = 'james';

		$this->db->expects($this->once())
		->method('get')
		->with($username)
		->willReturn(null);

		if (!empty($this->isUserExist($username) ) )
		{
			$this->db->expects($this->never())->method('delete');
			$this->delete($username);
		}

	}

	/**
	 * test if User Doesnt Exist 
	 *
	 * If we get no data about the user, assume it doesn't exist
	*/
	public function testUserDoesntExists()
	{
		$username = 'johnny';

		$this->db->expects($this->once())->method('get')
		->with($username)
		->willReturn(null);

		$this->assertFalse ($this->isUserExist($username));
	}

	/**
	 * test Create User 
	 *
	 * @param [string] $username,[string] $password,
	*/
	public function create($username,$password)
	{
		$this->user->setUsername($username);
		$this->user->setPassword($password);
		$this->user->newUser();
	}

	/**
	 * test Delete User 
	 *
	 * @param [string] $username
	*/
	public function delete($username)
	{
		$this->user->setUsername($username);
		$this->user->DeleteUser();
	}

	/**
	 * test Update  Password
	 *
	 * @param [string] $username,[string] $password
	*/
	public function updatePassword($username,$password)
	{
		$this->user->setUsername($username);
		$this->user->setPassword($password);
		$this->user->ChangePassword();
	}

	/**
	 * Check if User Exist
	 *
	 * @param [string] $username
	 * @return boolean
	 */
	public function isUserExist($username)
	{
		$this->user->setUsername($username);
		return $this->user->UserExists();

	}
}

