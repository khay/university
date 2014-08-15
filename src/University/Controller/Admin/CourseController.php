<?php 

namespace University\Controller\Admin;

use University\Model\Course;
use \Reborn\Form\Validation as Validation;
use Event, Flash, Redirect, Input, Pagination, Config;

/**
 * Course Controller
 *
 * @package University\Controller\Admin
 * @author Myanmar Links
 **/
class CourseController extends \AdminController
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
        $this->template->script('blog.js','blog');

        if ($this->request->isAjax())
            $this->template->partialOnly();
	}

	public function index()
	{
		$options = array(
            'total_items'       => Course::count(),
            'items_per_page'    => 25,
        );

        $pagination = Pagination::create($options);

        $courses = $this->getCourses(Pagination::offset(), Pagination::limit());

        $this->template->title(t('university::university.title.index'))                        
                        ->set('pagination', $pagination)
                        ->set('courses', $courses)
                        ->setPartial('admin/course/index');

        $dataTable = $this->template->partialRender('admin/course/table');
        $this->template->set('dataTable', $dataTable);
	}

	/**
	 * Add new course to a university
	 *
	 * @return void
	 * @author 
	 **/
	public function add()
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.addCourse'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				Flash::error(t('university::course.message.error.default'));
                $this->template->set('errors', $errors);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::course.message.success.add'));
				return \Redirect::toAdmin('university/course');
			}
		}

		$universities = $this->universities();
		$categories = $this->categories();

		$this->template->title(t('university::course.title.add'))
            ->breadcrumb(t('university::course.title.add'))
            ->setPartial('admin/course/form')
            ->set('universities', $universities)
            ->set('categories', $categories)
            ->set('method', 'add');
	}

	/**
	 * Edit a course details
	 *
	 * @param string $id
	 * @return void
	 **/
	public function edit($id = null)
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.addCourse'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				Flash::error(t('university::course.message.error.default'));
                $this->template->set('errors', $errors);
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::course.message.success.add'));
				return \Redirect::toAdmin('university');
			}
		}
		
		if (is_null($id))
            return Redirect::to(adminUrl('university/course'));

		$course = Course::find($id);
		$universities = $this->universities();

		$this->template->title(sprintf(t('university::course.title.edit'), $course->title))
            ->breadcrumb(sprintf(t('university::course.title.edit'), $course->title))
            ->setPartial('admin/university/form')
            ->set('course', $course)
            ->set('universities', $universities)
            ->set('method', 'edit');
	}

	/**
	 * Delete a course
	 *
	 * @param string $id
	 * @return void
	 **/
	public function delete($id)
	{
		if (is_null($id))
            return $this->notFound();

        $course = Course::find($id);
        $course->delete();

        Flash::success(t('university::course.message.success.delete'));
		return \Redirect::toAdmin('university/course');
	}

	/**
	 * Save course data
	 *
	 * @param string $method
	 * @return void
	 **/
	protected function saveValues($method)
	{		
		if ($method == 'add')
			$course = new Course;
		else
			$course = Course::find(Input::get('id'));

		$course->title = Input::get('title');
		$course->categoryId = Input::get('categoryId');
		$course->summary = Input::get('summary');
		$course->detail = Input::get('detail');
		$course->universityId = Input::get('universityId');
		$course->fee = Input::get('fee');
		$course->level = Input::get('level');
		$course->duration = Input::get('duration');
		$course->intake = Input::get('intake');
		$course->achievement = Input::get('achievement');

		$course->save();
	}

	/**
	 * Get all universities and give select options
	 *
	 * @return array
	 **/
	protected function universities()
	{
		$universities = \University\Model\University::all();
		
		foreach ($universities as $university) {
			$uni[$university->id] = $university->name;
		}

		return $uni;
	}

	/**
	 * Get all course categories and give select options
	 *
	 * @return array
	 **/
	public function categories()
	{
		$categories = \University\Model\Category::all();
		
		foreach ($categories as $category) {
			$cat[$category->id] = $category->name;
		}

		return $cat;
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
	 * Set university name to associated course
	 *
	 * @param int $offset
	 * @param int $limit
	 * @return void
	 * @author 
	 **/
	protected function getCourses($offset, $limit)
	{
		$courses = Course::skip($offset)              
                            ->limit($limit)       
                            ->sort('name', 'asc')
                            ->get();

        foreach ($courses as $course) {
        	$course->universityName = $this->getUniversity($course->universityId);
        }

        return $courses;
	}

	/**
	 * Get associated university for a course
	 *
	 * @param string $id
	 * @return string
	 **/
	protected function getUniversity($id)
	{
		$university = \University\Model\University::find($id);

		return $university->name;
	}
}