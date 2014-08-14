<?php 

namespace University\Controller\Admin;

use University\Model\Category;
use \Reborn\Form\Validation as Validation;
use Event, Flash, Redirect, Input, Pagination, Config;

/**
 * Course Category Controller
 *
 * @package University\Controller\Admin
 * @author Myanmar Links
 **/
class CategoryController extends \AdminController
{
	/**
	 * List all course categories
	 *
	 * @return void
	 **/
	public function index()
	{
	}

	/**
	 * Add new course category
	 *
	 * @return void
	 **/
	public function addCategory()
	{
	}

	/**
	 * Delete course category
	 *
	 * @param string $id
	 * @return void
	 **/
	public function deleteCategory($id)
	{
		if (is_null($id))
            return $this->notFound();

        $course = Course::find($id);
        $course->delete();

        Flash::success(t('university::course.message.success.delete'));
		return \Redirect::toAdmin('university/course/category');
	}