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

Route::group('@admin/university/course/', function() {
	Route::get('{p:page}?', 'University\Admin\Course::index', 'courseAdmin');
	Route::add('add', 'University\Admin\Course::add', 'courseAdd');
});

Route::group('@admin/university/category/', function() {
	Route::get('{p:page}?', 'University\Admin\Category::index', 'courseCatAdmin');
	Route::add('add', 'University\Admin\Category::add', 'courseCatAdd');
	Route::add('edit/{string:id}?', 'University\Admin\Category::edit', 'courseCatEdit');
	Route::add('delete/{string:id}', 'University\Admin\Category::delete', 'courseCatDelete');
});