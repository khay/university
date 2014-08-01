<?php 

namespace University\Controller\Admin;

use University\Model\University;
use \Reborn\Form\Validation as Validation;
use Event, Flash, Redirect, Input, Pagination, Config;

/**
 * University Controller
 *
 * @package University\Controller\Admin
 * @author Myanmar Links
 **/
class UniversityController extends \AdminController
{
	/**
	 * Before function for University
	 *
	 * @return void
	 **/
	public function before() 
	{
        $this->template->style('university.css', 'university');
	}

	/**
	 * Display all universities with pagination 
	 *
	 * @return void
	 * @author 
	 **/
	public function index()
	{
		// Will be working on this later!
	}

	/**
	 * Add new university
	 *
	 * @return void
	 **/
	public function add()
	{
		if (Input::isPost()) 
		{
			$validate = $this->validate(Config::get('university::validator.addForm'));

			dump($this->saveValues(Input::get('method')), true);
			
			if($validate->fail())
			{
				$errors = $validate->getErrors();
                $this->template->set('errors', $errors);
			}
			else
			{

			}
		}

		$this->template->title(t('university::university.title.add'))
            ->breadcrumb(t('university::university.title.add'))
            ->setPartial('admin/university/add');
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
	 * Save university data
	 *
	 * @param string $method
	 * @return boolean
	 **/
	protected function saveValues($method)
	{
		if ($method == 'create')
			$university = new University;
		else
			$university = University::find(Input::get('id'));

		dump($university, true);
	}
}