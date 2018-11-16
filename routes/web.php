<?php


Route::get('job/{id}/approve', 'JobController@approveJob')->name('job.approve');
Route::get('job/{id}/spam', 'JobController@markAsSpam')->name('job.spam');
Route::resource('/', 'JobController');