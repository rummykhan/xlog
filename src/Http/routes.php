<?php


Route::group(['namespace' => 'RummyKhan\XLog\Http\Controllers', 'middleware' => config('xlog.middleware')], function(){

    Route::get( config('xlog.routes.index.route'),      config('xlog.routes.index.action') );
    Route::get( config('xlog.routes.detail'),           config('xlog.routes.detail.action') );
    Route::delete( config('xlog.routes.delete'),        config('xlog.routes.delete.action') );

});