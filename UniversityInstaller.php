<?php

namespace Gallery;

class GalleryInstaller extends \Reborn\Module\AbstractInstaller
{

	public function install($prefix = null)
	{
		\Schema::table($prefix.'galleries', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->string('cover');
			$table->text('description');
			$table->integer('user_id');
			$table->enum('status', array('draft', 'live'))->default('draft');
			$table->integer('view_count')->default(0);
			$table->timestamps();
		});

		\Schema::table($prefix.'gallery_files', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('gallery_id');
			$table->string('label');
			$table->text('description');
			$table->string('type');
			$table->string('file_id');
			$table->string('file_url');
			$table->string('target_url')->nullable();
			$table->integer('position');
			$table->integer('width')->nullable();
            $table->integer('height')->nullable();
			$table->timestamps();
		});

		$settings = array(
			array(
				'slug'		=> 'gallery_image_width',
				'name'		=> 'Image Width',
				'desc'		=> 'Gallery album\'s image file thumbnail width',
				'value'		=> '',
				'default'	=> 200,
				'module'	=> 'Gallery'
			),
			array(
				'slug'		=> 'gallery_image_height',
				'name'		=> 'Image Height',
				'desc'		=> 'Gallery album\'s image file thumbnail height',
				'value'		=> '',
				'default'	=> 'auto',
				'module'	=> 'Gallery'
			),
			array(
				'slug'		=> 'gallery_photowall_zoomsize',
				'name'		=> 'Zoom size',
				'desc'		=> 'Zoom size for Photo Wall Effect',
				'value'		=> '',
				'default'	=> '1.5',
				'module'	=> 'Gallery'
			),
			array(
				'slug'		=> 'gallery_photowall_use_social',
				'name'		=> 'Enable Socail Link',
				'desc'		=> 'Enable Socail Link at Photo Wall',
				'value'		=> '',
				'default'	=> '1.5',
				'module'	=> 'Gallery'
			)
		);

		foreach ($settings as $setting) {
			\Setting::add($setting, $prefix);
		}
	}

	public function uninstall($prefix = null)
	{
		\Schema::drop($prefix.'galleries');
		\Schema::drop($prefix.'gallery_files');

		$settings = array(
			'gallery_image_width',
			'gallery_image_height',
			'gallery_photowall_zoomsize',
			'gallery_photowall_use_social'
		);

		foreach ($settings as $setting) {
			\Setting::remove($setting, $prefix);
		}
	}

	public function upgrade($dbVersion, $prefix = null)
	{
		if ($dbVersion == '1.0') {
			// Add target url field in gallery file
			\Schema::table($prefix.'gallery_files', function ($table) {
                $table->string('target_url')->nullable();
            });
		}
	}

}
