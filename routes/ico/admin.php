<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'ico', 'as' => 'ico.'], function () {
    Route::get('/', 'ManageIcoController@index')->name('index');
    Route::get('new', 'ManageIcoController@new')->middleware('demo')->name('new');
    Route::get('edit/{id}', 'ManageIcoController@edit')->middleware('demo')->name('edit');
    Route::post('store', 'ManageIcoController@store')->name('store')->middleware('demo');
    Route::post('update', 'ManageIcoController@update')->name('update')->middleware('demo');
    Route::post('remove', 'ManageIcoController@remove')->name('remove')->middleware('demo');

    // Log
    Route::get('log', 'ManageIcoController@log')->name('log.list');
    Route::post('log/pay', 'ManageIcoController@pay')->name('pay');
    Route::get('pending/log', 'ManageIcoController@pending')->name('log.pending');
    Route::get('completed/log', 'ManageIcoController@completed')->name('log.completed');
    Route::get('{scope}/search', 'ManageIcoController@search')->name('log.search');
});
