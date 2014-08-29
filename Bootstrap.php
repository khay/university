<?php

namespace University;

class Bootstrap extends \Reborn\Module\AbstractBootstrap
{

	/**
	 * This method will run when module boot.
	 *
	 * @return void;
	 */
	public function boot() {}

	/**
	 * Menu item register method for admin panel
	 *
	 * @return void
	 */
	public function adminMenu(\Reborn\Util\Menu $menu, $modUri)
	{
		$childs = array();

        $childs[] = array('title' => 'Universities', 'uri' => '');
        $childs[] = array('title' => 'Courses', 'uri' => 'course');
        $childs[] = array('title' => 'Categories', 'uri' => 'category');
        $childs[] = array('title' => 'Student Sheet', 'uri' => 'studentsheet');

        $menu->group($modUri, 'Uni Application', 'icon-college', 20, $childs);
	}

	/**
	 * Module Toolbar Data for Admin Panel
	 *
	 * @return array
	 */
	public function moduleToolbar()
	{
        $uri = \Uri::segment(3);

        if ( $uri == 'course') {
            $mod_toolbar = array(
                'addCourse'	=> array(
                    'url'	=> 'university/course/add',
                    'name'	=> t('university::course.label.add'),
                    'info'	=> t('university::course.label.add'),
                    'class'	=> 'add'
                )
            );
        } elseif ( $uri == 'studentsheet') {
            $mod_toolbar = array(
                'addCourse'	=> array(
                    'url'	=> 'university/studentsheet/add',
                    'name'	=> t('university::studentsheet.title.add'),
                    'info'	=> t('university::studentsheet.title.add'),
                    'class'	=> 'add'
                )
            );
        }else {
            $mod_toolbar = array(
                'add'	=> array(
                    'url'	=> 'university/add',
                    'name'	=> t('university::university.label.add'),
                    'info'	=> t('university::university.label.add'),
                    'class'	=> 'add'
                ),
            );
        }

        return $mod_toolbar;
	}

	/**
	 * Setting attributes for Module
	 *
	 * @return array
	 */
	public function settings() {}

	/**
	 * Register method for Module.
	 * This method will call application start.
	 * You can register at requirement for Reborn CMS.
	 *
	 */
	public function register() {}

}
