<?php

return array(
	'addUni'	=> array (
		'name'			=> 'required',
		'summary'		=> 'required',
		'about'			=> 'required',
		'city'			=> 'required',
		'email' 		=> 'required|email',
		'website'		=> 'required'
		),

	'addCourse'	=> array (
		'title'			=> 'required',
		'summary'		=> 'required',
		'detail'		=> 'required',
		'fee'			=> 'required'
		),

	'addCategory' => array (
		'name'			=> 'required',
		'slug'			=> 'required',
		'description'	=> 'required'
		),
	'addStudentsheet'	=> array(
		'name'			=> 'required',
		),

	);