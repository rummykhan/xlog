<?php


Route::group(['namespace' => 'RummyKhan\XLog\Http\Controllers', 'middleware' => config('xlog.middleware')], function(){

    Route::get( Config::get('xlog.routes.index'),      'XLogController@index' );
    Route::get( Config::get('xlog.routes.detail'),     'XLogController@detail' );
    Route::delete( Config::get('xlog.routes.delete'),  'XLogController@delete' );

});