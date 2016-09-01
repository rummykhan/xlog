<?php

namespace RummyKhan\XLog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use RummyKhan\XLog\Models\Log;

class XLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(Config::get('xlog.middleware'));
    }

    public function index()
    {
        $logs = Log::paginate(50);

        return view('xlog::index', compact('logs'));
    }

    public function detail($id)
    {
        return dd('detail');
    }

    public function delete($id)
    {
        return dd('delete');
    }
}