<?php

use Illuminate\Support\Facades\Route;

Route::post('/fetch/bot', 'BotController@fetch_info')->middleware('checkKYC')->name('fetch.info');
Route::post('/fetch/bot/info', 'BotController@fetch_bot')->middleware('checkKYC')->name('fetch.bot');
Route::post('/store/bot', 'BotController@store')->middleware('checkKYC')->name('store.bot');
