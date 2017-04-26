<?php

namespace RummyKhan\XLog\Models;

if( config('xlog.db_type') === 'mongo' && class_exists('Jenssegers\Mongodb\Eloquent\Model') ){
    class ProxyModel extends \Jenssegers\Mongodb\Eloquent\Model { }
}else{
    class ProxyModel extends \Illuminate\Database\Eloquent\Model { }
}