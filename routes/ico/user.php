<?php

use Illuminate\Support\Facades\Route;

Route::post('/fetch/ico', 'IcoController@fetch_info')->middleware('checkKYC')->name('fetch.ico');
Route::post('/fetch/ico/{symbol}', 'IcoController@fetch_ico_info')->middleware('checkKYC')->name('fetch.ico.info');
Route::post('/store/ico', 'IcoController@store')->middleware('checkKYC')->name('store.ico');
Route::post('/store/ico/rec_wallet', 'IcoController@store_rec_wallet')->middleware('checkKYC')->name('store.ico.rec_wallet');
