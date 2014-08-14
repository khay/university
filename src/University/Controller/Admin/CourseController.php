<?php 

namespace University\Controller\Admin;

use University\Model\Course;
use University\Model\Category;
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
		dump('This works', true);
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

		$this->template->title(t('university::course.title.add'))
            ->breadcrumb(t('university::course.title.add'))
            ->setPartial('admin/course/form')
            ->set('universities', $universities)
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
}