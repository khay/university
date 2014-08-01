<?php

/** 
 * Routes for University Application 
 *
 **/

// University

Route::group('@admin/university/', function() {
	Route::get('{p:page}?', 'University\Admin\University::index', 'uniAdmin');
    Route::add('add', 'University\Admin\University::add', 'uniAdd');
    Route::add('edit/{string:id}?/', 'University\Admin\University::edit', 'uniEdit');
    Route::get('delete/{string:id}', 'University\Admin\University::delete', 'uniDelete');
    Route::post('search', 'University\Admin\University::search', 'uniSearch');
});