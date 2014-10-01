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
		$this->_student = Auth::getUser();
		$student = Auth::getGroupProvider()->findBy('name', 'Students');
		$this->template->set('student', $this->_student);	
	}

	/**
	 * Student will starts from here
	 *
	 * @return void
	 **/
	public function index() 
	{
		$this->template->title(sprintf(t('university::student.title.index'), $this->_student->full_name))
            ->breadcrumb(t('university::student.title.index'))
            ->setPartial('student/index')
            ->set('student', $this->_student);
	}

	/**
	 * The same as user profile edit
	 * this one is for student views
	 *
	 * @return void
	 **/
	public function edit()
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.editStudent'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();				
				Flash::error(t('university::agent.message.error.default'));
                $this->template->set('errors', $errors);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::agent.message.success.add'));
				return \Redirect::to('university/agent');
			}
        }     

        $this->template->title(t('university::student.title.edit'))
            ->breadcrumb(t('university::student.title.edit'))
            ->setPartial('student/form')
            ->set('student', $this->_student);        
	}

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