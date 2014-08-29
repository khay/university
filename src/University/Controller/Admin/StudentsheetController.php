<?php 

namespace University\Controller\Admin;

use University\Model\Studentsheet;
use \Reborn\Form\Validation as Validation;
use Event, Flash, Redirect, Input, Pagination, Config;

/**
 * University Controller
 *
 * @package University\Controller\Admin
 * @author Myanmar Links
 **/
class StudentsheetController extends \AdminController
{
	/**
	 * Before function for University
	 *
	 * @return void
	 **/
	public function before() 
	{
		$this->menu->activeParent('university');
        $this->template->style('university.css', 'university');
        $this->template->script('app.js', 'university');

        if ($this->request->isAjax())
            $this->template->partialOnly();
	}

	/**
	 * Display all universities with pagination 
	 *
	 * @return void
	 * @author 
	 **/
	public function index()
	{
        $options = array(
            'total_items'       => Studentsheet::count(),
            'items_per_page'    => 25,
        );

        $pagination = Pagination::create($options);

        $students = Studentsheet::skip(Pagination::offset())              
                            ->limit(Pagination::limit())       
                            ->sort('name', 'asc')
                            ->get();

        $this->template->title(t('university::university.title.index'))                        
                        ->set('pagination', $pagination)
                        ->set('students', $students)
                        ->style('jquery.dataTables.min.css', 'university')
        				->script('jquery.dataTables.min.js', 'university')
                        ->setPartial('admin/studentsheet/index');

        $dataTable = $this->template->partialRender('admin/studentsheet/table');
        $this->template->set('dataTable', $dataTable);
	}

	/**
	 * Add new student into student sheet
	 *
	 * @return void
	 **/
	public function add()
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.addStudentsheet'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				Flash::error(t('university::studentsheet.message.error.default'));
                $this->template->set('errors', $errors);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::studentsheet.message.success.add'));
				return \Redirect::toAdmin('university/studentsheet/');
			}
		}

		$this->template->title(t('university::studentsheet.title.add'))
            ->breadcrumb(t('university::studentsheet.title.add'))
            ->setPartial('admin/studentsheet/form')            
            ->set('method', 'add');
	}

	/**
	 * Update a student information from student sheet
	 *
	 * @return void
	 **/
	public function edit($id = null)
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.addStudentsheet'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				Flash::error(t('university::studentsheet.message.error.default'));
                $this->template->set('errors', $errors);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::studentsheet.message.success.add'));
				return \Redirect::toAdmin('university/studentsheet/');
			}
		}

		if (is_null($id))
            return Redirect::to(adminUrl('university/studentsheet'));

		$student = StudentSheet::find($id);

		$this->template->title(t('university::studentsheet.title.add'))
            ->breadcrumb(t('university::studentsheet.title.add'))
            ->setPartial('admin/studentsheet/form')
            ->set('student', $student)
            ->set('method', 'edit');
	}

	/**
	 * Delete the university
	 *
	 * @param string $id
	 * @return void
	 **/
	public function delete($id = null)
	{
		if (is_null($id))
            return $this->notFound();

        $student = Studentsheet::find($id);        
        $student->delete();

        Flash::success(t('university::studentsheet.message.success.delete'));
		return \Redirect::toAdmin('university/studentsheet');
	}

	/**
	 * Save student data for studentsheet
	 *
	 * @param string $method
	 * @return void
	 **/
	protected function saveValues($method)
	{		
		if ($method == 'add')
			$student = new Studentsheet;
		else
			$student = Studentsheet::find(Input::get('id'));

		$student->name = Input::get('name');
		$student->phone = Input::get('phone');
		$student->email = Input::get('email');
		$student->copta = Input::get('copta');
		$student->coptb = Input::get('coptb');
		$student->sopta = Input::get('sopta');
		$student->soptb = Input::get('soptb');
		$student->status = Input::get('status');
		$student->officer = Input::get('officer');
		$student->studywithin = Input::get('studywithin');
		$student->notes = Input::get('notes');

		$student->save();
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