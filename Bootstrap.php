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
		$menu->add('university', 'University', $modUri, 'archive', 20);
	}

	/**
	 * Module Toolbar Data for Admin Panel
	 *
	 * @return array
	 */
	public function moduleToolbar()
	{
		return array(
                'upload'    => array(
                    'url'   => 'gallery',
                    'name'  => 'All',
                    'info'  => 'View all gallery lists',
                    'id'    => 'gallery_lists',
                ),
                'create'    => array(
                    'url'   => 'gallery/create/',
                    'name'  => 'Create',
                    'info'  => 'Create New Gallery',
                    'id'    => 'create_gallery',
                ),
            );
	}

	/**
	 * Setting attributes for Module
	 *
	 * @return array
	 */
	public function settings()
	{
		return array(
			'gallery_image_width' => array(
				'type' => 'text'
				),
			'gallery_image_height'	=> array(
				'type' => 'text'
				),
			'gallery_photowall_zoomsize' => array(
				'type' => 'text'
				),
			'gallery_photowall_use_social' => array(
					'type'	=> 'select',
					'options' => array('enable' => 'Enable', 'disable'=>'Disable')
				)
			);
	}

	/**
	 * Register method for Module.
	 * This method will call application start.
	 * You can register at requirement for Reborn CMS.
	 *
	 */
	public function register()
	{
		// Bind \Media\Api for Controller Injection
		$this->app->bind('\Media\Api', function(){
			return new \Media\Api();
		});

		// Define Gallery Asset Path
		if (!defined('GALLERY_ASSET')) {
			define('GALLERY_ASSET', __DIR__.DS.'assets'.DS);
		}

		// Define Gallery View Path
		if (!defined('GALLERY_VIEW')) {
			define('GALLERY_VIEW', __DIR__.DS.'views'.DS);
		}

		// Make Class Alias
        \Alias::aliasRegister(array('Gallery' => 'Gallery\Facade\Gallery'));
	}

}
