<?php

/** 
 * Routes for University Application 
 *
 **/

// University

Route::group('@admin/university/', function() {
	Route::get('{p:page}?', 'University\Admin\University::index', 'uniAdmin');
	Route::add('view/{string:id}?/', 'University\Admin\University::view', 'uniView');
    Route::add('add', 'University\Admin\University::add', 'uniAdd');
    Route::add('edit/{string:id}?/', 'University\Admin\University::edit', 'uniEdit');
    Route::get('delete/{string:id}', 'University\Admin\University::delete', 'uniDelete');
    Route::post('search', 'University\Admin\University::search', 'uniSearch');
});

// Course

Route::group('@admin/university/course/', function() {
	Route::get('{p:page}?', 'University\Admin\Course::index', 'courseAdmin');
	Route::add('add', 'University\Admin\Course::add', 'courseAdd');
	Route::add('edit/{string:id}?', 'University\Admin\Course::edit', 'courseEdit');
	Route::add('delete/{string:id}', 'University\Admin\Course::delete', 'courseDelete');
	Route::post('search', 'University\Admin\Course::search', 'courseSearch');
});

// Course Category

Route::group('@admin/university/category/', function() {
	Route::get('{p:page}?', 'University\Admin\Category::index', 'courseCatAdmin');
	Route::add('add', 'University\Admin\Category::add', 'courseCatAdd');
	Route::add('edit/{string:id}?', 'University\Admin\Category::edit', 'courseCatEdit');
	Route::add('delete/{string:id}', 'University\Admin\Category::delete', 'courseCatDelete');
});

// Studentsheet

Route::group('@admin/university/studentsheet', function() {
	Route::get('', 'University\Admin\Studentsheet::index', 'studentsheetAdmin');
	Route::add('add', 'University\Admin\Studentsheet::add', 'studentsheetAdd');
	Route::add('edit/{string:id}?', 'University\Admin\Studentsheet::edit', 'studentsheetEdit');
	Route::add('delete/{string:id}', 'University\Admin\Studentsheet::delete', 'studentsheetDelete');
});

// Agent

Route::group('university/agent', function() {
	Route::get('', 'University\Agent::index', 'agent');
	Route::add('student/add/{int:agentId}?', 'University\Agent::addStudent', 'agentStudentAdd');
	Route::add('student/edit/{string:id}?', 'University\Agent::editStudent', 'agentStudentEdit');
	Route::add('student/delete/{string:id}', 'University\Agent::deleteStudent', 'agentStudentDelete');
});