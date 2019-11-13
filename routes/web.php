<?php


Route::get('job/{id}/approve', 'JobController@approve_job')->name('job.approve');
Route::get('job/{id}/spam', 'JobController@mark_as_spam')->name('job.spam');
Route::resource('/', 'JobController')->only(['index', 'store']);
