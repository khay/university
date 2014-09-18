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
		$students = array();

		$agents = Agent::like('agentId', $this->agent->id)->get();		
		foreach ($agents as $agent) {
			$students = Auth::get($agent->studentId);
		}

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
	public function addStudent($agentId = null)
	{
		if (is_null($agentId) or ($agentId != $this->agent->id)) 
			return $this->notFound();

		if (Input::isPost()) {
			dump(Input::get(), true);
			$validate = $this->validate(Config::get('university::validator.addStudent'));	
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				Flash::error(t('university::agent.message.error.default'));
                $this->template->set('errors', $errors);
                dump($errors, true);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::agent.message.success.add'));
				dump('Yay', true);
				return \Redirect::to('university/agent');
			}
        }

        $this->template->title(t('university::agent.title.add'))
            ->breadcrumb(t('university::agent.title.add'))
            ->setPartial('agent/form')
            ->set('agentId', $agentId)
            ->set('method', 'add');
	}

	/**
	 * Edit a student for associated agent.
	 *
	 * @param integer $agentId
	 * @return void
	 **/
	public function editStudent($agentId = null) 
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

        $this->template->title(t('university::agent.title.edit'))
            ->breadcrumb(t('university::agent.title.edit'))
            ->setPartial('agent/form')
            ->set('agentId', $agentId)
            ->set('method', 'edit');
	}

	/**
	 * Delete a student for associated agent.
	 *
	 * @param string $agentId
	 * @param string $studentId
	 * @return void
	 **/
	public function deleteStudent($agentId = null, $studentId) {}

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

			$agent->agentId = Input::get('agentId');
			$agent->userId = $user->id;
			$agent->save();	
		} else {			
			$agent = Agent::find(Input::get('agentId'));
			$user = Auth::getUserProvider()->findById($agent->userId);

			// Update student info
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->email = Input::get('email');
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

}