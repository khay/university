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