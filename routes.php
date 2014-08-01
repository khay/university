<?php

/** 
 * Routes for University Application 
 *
 **/

// University

Route::group('@admin/university/', function() {
	Route::get('{p:pagi}?', 'University\Admin\University::index', 'uniAdmin');
    Route::add('add', 'University\Admin\University::add', 'uniAdd');
    Route::add('edit/{int:id}/', 'University\Admin\University::edit', 'uniEdit');
    Route::get('delete/{int:id}', 'University\Admin\University::delete', 'uniDelete');
});