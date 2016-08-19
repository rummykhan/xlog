<?php


Route::group(['namespace' => 'RummyKhan\XLog\Http\Controllers'], function(){

    Route::get(Config::get('xlog.routes.index'),      'XLogController@index');
    Route::get(Config::get('xlog.routes.detail'),     'XLogController@detail');
    Route::delete(Config::get('xlog.routes.delete'),  'XLogController@delete');

});