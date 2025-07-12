<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Service; // Jika Anda memiliki model Service

class ServiceHistoryController extends Controller
{
    public function index()
    {
        // Logika untuk mengambil data dari MySQL
        // Contoh: $serviceHistory = Service::all(); // Pastikan Anda memiliki model Service
        // Jika Anda ingin mengirim data ke view, Anda akan menggunakannya seperti ini:
        // return view('admin.services.history', compact('serviceHistory'));

        return view('admin.services.history');
    }
}