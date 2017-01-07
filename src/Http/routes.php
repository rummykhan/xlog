<?php


Route::group(['namespace' => 'RummyKhan\XLog\Http\Controllers', 'middleware' => config('xlog.middleware')], function(){

    Route::get( config('xlog.routes.index.route'),      config('xlog.routes.index.action') );
    Route::get( config('xlog.routes.detail.route'),           config('xlog.routes.detail.action') );
    Route::delete( config('xlog.routes.delete.route'),        config('xlog.routes.delete.action') );

});