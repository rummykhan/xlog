<?php

namespace RummyKhan\XLog\Http\Controllers;

use App\Http\Controllers\Controller;
use RummyKhan\XLog\Models\Log;

class XLogController extends Controller
{

    public function __construct()
    {
        $this->middleware(config('xlog.middleware'));
    }
    
    public function index()
    {
        $logs = Log::paginate(15);

        return view('xlog::index', compact('logs'));
    }

    public function detail($id)
    {
        $log = Log::find($id);
        if( !$log )
            abort(404);

        return view('xlog::detail', compact('log'));
    }

    public function delete($id)
    {
        $log = Log::find($id);
        if( !$log )
            abort(404);

        $log->delete();

        return redirect(config('xlog.routes.index.route'))->with('message', 'Deleted successfully!');
    }
}