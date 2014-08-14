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
	 * Before function for University
	 *
	 * @return void
	 **/
	public function before() 
	{
		$this->menu->activeParent('university');
        $this->template->style('university.css', 'university');
        $this->template->script('app.js','university');

        if ($this->request->isAjax())
            $this->template->partialOnly();
	}

	/**
	 * List all course categories
	 *
	 * @return void
	 **/
	public function index()
	{

        $categories = Category::sort('name', 'asc')->get();

        $this->template->title(t('university::category.title.index'))
                        ->set('categories', $categories)
                        ->set('method', 'add')
                        ->setPartial('admin/category/index');
	}

	/**
	 * Add new course category
	 *
	 * @return void
	 **/
	public function add()
	{
		if (Input::isPost()) {
			$validate = $this->validate(Config::get('university::validator.addCategory'));
		
			if($validate->fail()) {
				$errors = $validate->getErrors();
				Flash::error(t('university::category.message.error.default'));
                $this->template->set('errors', $errors);                
			} else {
				$this->saveValues(Input::get('method'));
				Flash::success(t('university::category.message.success.add'));
			}
		}

		return \Redirect::toAdmin('university/category');
	}

	/**
	 * Delete course category
	 *
	 * @param string $id
	 * @return void
	 **/
	public function delete($id)
	{
		if (is_null($id))
            return $this->notFound();

        $category = Category::find($id);
        $category->delete();

        Flash::success(t('university::category.message.success.delete'));
		return \Redirect::toAdmin('university/category');
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
			$category = new Category;
		else
			$category = Category::find(Input::get('id'));

		$category->name = Input::get('name');
		$category->slug = Input::get('slug');
		$category->description = Input::get('description');

		$category->save();
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