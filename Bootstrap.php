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

        $menu->group($modUri, 'Uni Application', 'icon-college', 20, $childs);
	}

	/**
	 * Module Toolbar Data for Admin Panel
	 *
	 * @return array
	 */
	public function moduleToolbar()
	{
		return array(
            'add'    => array(
                'url'   => 'university/add/',
                'name'  => 'Add University',
                'info'  => 'Add New University',
                'id'    => 'addUniversity',
            ),
        );
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
