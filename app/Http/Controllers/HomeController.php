<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\DataRequest;
use App\Models\ErrorReport;
use App\Models\Complaint;
use App\Models\SimakFeatureRequest;
use App\Models\FeederSyncRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman selamat datang (welcome page) dengan pengumuman dan daftar permintaan terbaru.
     */
    public function index()
    {
        // Mengambil 5 pengumuman terbaru yang sudah dipublikasikan
        $latestAnnouncements = Announcement::where('published_at', '<=', Carbon::now())
                                           ->orderBy('published_at', 'desc')
                                           ->limit(5)
                                           ->get();

        // Mengambil 5 permintaan data terbaru yang TIDAK berstatus 'pending'
        $latestDataRequests = DataRequest::where('status', '!=', 'pending')
                                         ->orderBy('created_at', 'desc')
                                         ->limit(5)
                                         ->get();

        // Mengambil 5 laporan error terbaru yang TIDAK berstatus 'new'
        $latestErrorReports = ErrorReport::where('status', '!=', 'new')
                                         ->orderBy('created_at', 'desc')
                                         ->limit(5)
                                         ->get();

        // Mengambil 5 keluhan terbaru yang TIDAK berstatus 'pending'
        $latestComplaints = Complaint::where('status', '!=', 'pending')
                                     ->orderBy('created_at', 'desc')
                                     ->limit(5)
                                     ->get();

        // Mengambil 5 permintaan fitur SIMAK terbaru yang TIDAK berstatus 'new'
        $latestSimakFeatureRequests = SimakFeatureRequest::where('status', '!=', 'new')
                                                          ->orderBy('created_at', 'desc')
                                                          ->limit(5)
                                                          ->get();

        // Mengambil 5 permintaan sinkronisasi Feeder terbaru yang TIDAK berstatus 'pending'
        $latestFeederSyncRequests = FeederSyncRequest::where('status', '!=', 'pending')
                                                      ->orderBy('created_at', 'desc')
                                                      ->limit(5)
                                                      ->get();

        // Meneruskan semua variabel ke view welcome
        return view('welcome', compact(
            'latestAnnouncements',
            'latestDataRequests',
            'latestErrorReports',
            'latestComplaints',
            'latestSimakFeatureRequests',
            'latestFeederSyncRequests'
        ));
    }
}
