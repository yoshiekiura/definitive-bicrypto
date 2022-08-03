<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'bot', 'as' => 'bot.'], function() {
    Route::get('/', 'ManageBotController@index')->name('index');
    Route::get('new', 'ManageBotController@new')->name('new');
    Route::get('edit/{id}', 'ManageBotController@edit')->name('edit');
    Route::post('set', 'ManageBotController@set')->name('set')->middleware('demo');
    Route::post('store', 'ManageBotController@store')->name('store')->middleware('demo');
    Route::post('update', 'ManageBotController@update')->name('update')->middleware('demo');
    Route::post('remove', 'ManageBotController@remove')->name('remove')->middleware('demo');

    // Log
    Route::get('log', 'ManageBotController@log')->name('log.list');
    Route::get('pending/log', 'ManageBotController@pending')->name('log.pending');
    Route::get('completed/log', 'ManageBotController@completed')->name('log.completed');
    Route::get('{scope}/search', 'ManageBotController@search')->name('log.search');

    // Time
    Route::group(['prefix' => 'time', 'as' => 'time.'], function() {
        Route::get('/{id}', 'ManageBotController@indexTime')->name('index');
        Route::post('store', 'ManageBotController@storeTime')->name('store')->middleware('demo');
        Route::post('update', 'ManageBotController@updateTime')->name('update')->middleware('demo');
        Route::post('remove', 'ManageBotController@removeTime')->name('remove')->middleware('demo');
    });
});
