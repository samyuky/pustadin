<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Service;

class ServiceHistoryController extends Controller
{
    public function index()
    {
        return view('admin.services.history');
    }
}