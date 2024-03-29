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
            'total_items'       => University::count(),
            'items_per_page'    => 25,
        );

        $pagination = Pagination::create($options);

        $universities = University::skip(Pagination::offset())              
                            ->limit(Pagination::limit())       
                            ->sort('name', 'asc')
                            ->get();

        $this->template->title(t('university::university.title.index'))                        
                        ->set('pagination', $pagination)
                        ->set('universities', $universities)
                        ->setPartial('admin/university/index');

        $dataTable = $this->template->partialRender('admin/university/table');
        $this->template->set('dataTable', $dataTable);

        
	}

	/**
	 * Display second page for university
	 * To add available courses
	 *
	 * @param string $id
	 * @return void	 
	 **/
	public function view($id = null)
	{
		if (is_null($id))
            return Redirect::to(adminUrl('university'));

		$university = University::find($id);
		$courses = $this->getCourses($university->id);

		$this->template->title(t('university::university.title.view'))
            ->breadcrumb(t('university::university.title.view'))
            ->setPartial('admin/university/view')
            ->set('university', $university)
            ->set('courses', $courses);

	}

	/**
	 * Add new university
	 *
	 * @return void
	 **/
	public function add()
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.addUni'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				Flash::error(t('university::university.message.error.default'));
                $this->template->set('errors', $errors);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::university.message.success.add'));
				return \Redirect::toAdmin('university');
			}
		}

		$this->template->title(t('university::university.title.add'))
            ->breadcrumb(t('university::university.title.add'))
            ->setPartial('admin/university/form')
            ->set('method', 'add');
	}

	/**
	 * Edit a university information
	 *
	 * @param string $id
	 * @return void
	 **/
	public function edit($id = null)
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.addUni'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				Flash::error(t('university::university.message.error.default'));
                $this->template->set('errors', $errors);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::university.message.success.add'));
				return \Redirect::toAdmin('university');
			}
		}
		
		if (is_null($id))
            return Redirect::to(adminUrl('university'));

		$university = University::find($id);

		$this->template->title(sprintf(t('university::university.title.edit'), $university->name))
            ->breadcrumb(sprintf(t('university::university.title.edit'), $university->name))
            ->setPartial('admin/university/form')
            ->set('university', $university)
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

        $university = University::find($id);
        $university->delete();

        Flash::success(t('university::university.message.success.delete'));
		return \Redirect::toAdmin('university');
	}

	/**
     * Ajax university search
     *
     * @return void
     **/
    public function search()
    {
        $term = Input::get('term');

        if ($term) {
            $result = University::like('name', $term)
            			->get();
        } else {
            $options = array(
                'total_items'       => University::count(),
                'items_per_page'    => 25,
            );

            $pagination = Pagination::create($options);

            $result = University::sort('name', 'asc')
                            ->skip(Pagination::offset())
                            ->limit(Pagination::limit())
                            ->get();

            $this->template->set('pagination', $pagination);

        }

        $this->template->partialOnly()
             ->set('universities', $result)
             ->setPartial('admin/university/table');
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
	 * @return void
	 **/
	protected function saveValues($method)
	{		
		if ($method == 'add')
			$university = new University;
		else
			$university = University::find(Input::get('id'));

		$university->name = Input::get('name');
		$university->summary = Input::get('summary');
		$university->about = Input::get('about');
		$university->country = Input::get('country');
		$university->city = Input::get('city');
		$university->phone = Input::get('phone');
		$university->fax = Input::get('fax');
		$university->email = Input::get('email');
		$university->website = Input::get('website');
		$university->photo = Input::get('photo');

		$university->save();
	}

	/**
	 * Get available courses from a university
	 *
	 * @param string $id
	 * @return object
	 **/
	protected function getCourses($id)
	{
		$courses = \University\Model\Course::where('universityId', '=', $id)->get();

		foreach ($courses as $course) {        	
        	$course->categoryName = $this->getCategory($course->categoryId);
        }

		return $courses;
	}

	/**
	 * Get associated category for a course
	 *
	 * @param string $id
	 * @return string
	 **/
	protected function getCategory($id)
	{
		$category = \University\Model\Category::find($id);

		return $category->name;
	}
}