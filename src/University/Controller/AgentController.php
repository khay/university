<?php

namespace University\Controller;

use University\Model\Agent;
use \Reborn\Form\Validation as Validation;
use Event, Flash, Redirect, Input, Pagination, Config, Auth, UserGroup;

/**
 * Agent Controller
 *
 * @package University\Controller
 * @author Myanmar Links
 **/
class AgentController extends \PrivateController
{
	protected $agent;

	/**
	 * Before function for Agent
	 *
	 * @return void
	 **/
	public function before() 
	{
		$this->agent = Auth::getUser();
		$agent = Auth::getGroupProvider()->findBy('name', 'Agents');

		if(!$this->agent->inGroup($agent)) return Redirect::to('/');

		$this->template->set('agent', $this->agent);	
	}

	/**
	 * Index function for Agent
	 *
	 * @return void
	 **/
	public function index() 
	{
		$agents = Agent::where('agentId', "=" , $this->agent->id)->get();

		$students = $this->getStudents($agents);

		$this->template->title(sprintf(t('university::agent.title.index'), $this->agent->full_name))
            ->breadcrumb(t('university::agent.title.index'))
            ->setPartial('agent/index')
            ->set('students', $students);
	}

	/**
	 * Create a student via Agent
	 *
	 * @param integer $agentId
	 * @return void
	 */
	public function addStudent()
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.addStudent'));	
		
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

        $this->template->title(t('university::agent.title.add'))
            ->breadcrumb(t('university::agent.title.add'))
            ->setPartial('agent/form')
            ->set('agentId', $this->agent->id)
            ->set('method', 'add');
	}

	/**
	 * Edit a student for associated agent.
	 *
	 * @param integer $agentId
	 * @return void
	 **/
	public function editStudent($studentId = null) 
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.editStudent'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				$studentId = Input::get('studentId');
				Flash::error(t('university::agent.message.error.default'));
                $this->template->set('errors', $errors);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::agent.message.success.add'));
				return \Redirect::to('university/agent');
			}
        }

       	if (is_null($studentId)) return $this->notFound();

        $student = Auth::getUserProvider()->findById($studentId);

        $this->template->title(t('university::agent.title.edit'))
            ->breadcrumb(t('university::agent.title.edit'))
            ->setPartial('agent/form')
            ->set('student', $student)
            ->set('agentId', $this->agent->id)
            ->set('method', 'edit');
	}

	/**
	 * View student information of a student
	 *
	 * @param int $id
	 * @return void
	 **/
	public function viewStudent($agentId = null, $studentId = null)
	{
		if (is_null($agentId) or ($agentId != $this->agent->id)) 
			return $this->notFound();

		$this->template->title(t('university::agent.title.student'))
            ->breadcrumb(t('university::agent.title.student'))
            ->setPartial('agent/student')
            ->set('student', $student);            
	}

	/**
	 * Delete a student for associated agent.
	 *
	 * @param string $agentId
	 * @param string $studentId
	 * @return void
	 **/
	public function deleteStudent($studentId = null) 
	{
		if (is_null($studentId)) return $this->notFound();

    	$user = Auth::getUserProvider()->findById($studentId);
    	$agent = Agent::where('userId', "=" , $user->id)->get();

    	$user->delete();
    	$agent->delete();

        Flash::success(t('university::agent.message.delete'));
        return Redirect::to('university/agent');
	}

	/**
	 * Update agent information
	 *
	 * @return void	 
	 **/
	public function editAgent() {}

	/**
	 * Save values of a student with associated agent
	 *
	 * @return void
	 **/
	protected function saveValues($method)
	{
		if ($method == 'add') {
			$agent = new Agent;

			$user = Auth::getUserProvider()->create(array(
				'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'email'    => Input::get('email'),
                'password' => Input::get('password'),
                'activated' => 1
            ));

			$agent->agentId = $this->agent->id;
			$agent->userId = $user->id;
			$agent->save();	
		} else {			
			$user = Auth::getUserProvider()->findById(Input::get('studentId'));

			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->email = Input::get('email');
			
			if (!empty(Input::get('password')))
				$user->password = Input::get('password');

			$user->save();
		}
	}

	/**
	 * Check form validation
	 *
	 * @param array $rules
	 * @return array
	 **/
	protected function validate($rules)
	{	
		return new Validation(Input::get('*'), $rules);
	}

	/**
	 * Get students information of an agent
	 *
	 * @param object $agents
	 * @return array
	 * @author 
	 **/
	protected function getStudents($agents)
	{
		$students = array();

		foreach ($agents as $key => $agent) {						
			$students[] = Auth::find($agent->userId);
		}

		return $students;
	}

}