<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\DataRequest;
use App\Models\ErrorReport;
use App\Models\Complaint; // Perbaikan: Menggunakan backslash (\) bukan panah (->)
use App\Models\SimakFeatureRequest; // Perbaikan: Menggunakan backslash (\) bukan panah (->)
use App\Models\FeederSyncRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman selamat datang (welcome page) dengan pengumuman terbaru
     * dan daftar permintaan layanan yang relevan, tidak termasuk yang berstatus 'pending' atau 'new'.
     */
    public function index()
    {
        // Mengambil 5 pengumuman terbaru yang sudah dipublikasikan
        $latestAnnouncements = Announcement::where('published_at', '<=', Carbon::now())
                                           ->orderBy('published_at', 'desc')
                                           ->limit(5)
                                           ->get();

        // Mengambil 5 permintaan data terbaru, tidak termasuk 'pending'
        $latestDataRequests = DataRequest::where('status', '!=', 'pending')
                                         ->latest()
                                         ->limit(5)
                                         ->get();

        // Mengambil 5 laporan error terbaru, tidak termasuk 'new' atau 'pending'
        $latestErrorReports = ErrorReport::whereNotIn('status', ['new', 'pending'])
                                         ->latest()
                                         ->limit(5)
                                         ->get();

        // Mengambil 5 keluhan terbaru, tidak termasuk 'pending'
        $latestComplaints = Complaint::where('status', '!=', 'pending')
                                     ->latest()
                                     ->limit(5)
                                     ->get();

        // Mengambil 5 permintaan fitur SIMAK terbaru, tidak termasuk 'new' atau 'pending'
        $latestSimakFeatureRequests = SimakFeatureRequest::whereNotIn('status', ['new', 'pending'])
                                                          ->latest()
                                                          ->limit(5)
                                                          ->get();

        // Mengambil 5 permintaan sinkronisasi Feeder terbaru, tidak termasuk 'pending'
        $latestFeederSyncRequests = FeederSyncRequest::where('status', '!=', 'pending')
                                                      ->latest()
                                                      ->limit(5)
                                                      ->get();

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
