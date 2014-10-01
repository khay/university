<?php

namespace University\Controller;

use University\Model\Student;
use \Reborn\Form\Validation as Validation;
use Event, Flash, Redirect, Input, Pagination, Config, Auth, UserGroup;

/**
 * Student Controller
 * Students can edit/update their profiles.
 *
 * @package University\Controller
 * @author Hexcores
 **/
class StudentController extends \PrivateController
{
	protected $_student;

	/**
	 * Before function for Student
	 *
	 **/
	public function before() 
	{
		// Get current logged in user and check in Students group or not
		$this->_student = Auth::getUser();
		$student = Auth::getGroupProvider()->findBy('name', 'Students');

		if(!$this->_student->inGroup($student)) return Redirect::to('/');

		$this->template->set('student', $this->_student);	
	}

	/**
	 * Students will starts from here
	 *
	 * @return void
	 **/
	public function index() {}

	/**
	 * The same as user profile edit
	 * this one is for student views
	 *
	 * @return void
	 **/
	public function edit() {}

	/**
	 * You don't like your old password?
	 * Fine! Now you can change your password
	 * but unless old password you won't be able to change
	 *
	 * @return void
	 **/
	public function changePassword() {}

	/**
	 * Save values for users and student details
	 *
	 * @param string $method
	 * @return void
	 **/
	protected function _saveValues($method) {}
}