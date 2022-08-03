<?php

use Illuminate\Support\Facades\Route;

Route::get('cron/bot/result', 'CronController@botResult')->name('bot.result');
Route::get('cron/bot/missed', 'CronController@botMissed')->name('bot.missed');
