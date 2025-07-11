<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DataRequest; // Pastikan model ini ada
use App\Models\ErrorReport; // Pastikan model ini ada
use App\Models\Complaint;   // Pastikan model ini ada
use App\Models\SimakFeatureRequest; // Pastikan model ini ada
use App\Models\FeederSyncRequest; // Pastikan model ini ada
use App\Models\Announcement; // Pastikan ini adalah model yang benar, bukan BulletinBoardAnnouncement

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        // Mengambil data untuk dashboard
        $totalDataRequests = DataRequest::count();
        $pendingDataRequests = DataRequest::where('status', 'pending')->count();

        $totalErrorReports = ErrorReport::count();
        $newErrorReports = ErrorReport::where('status', 'new')->count();

        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();

        $totalSimakFeatureRequests = SimakFeatureRequest::count();
        $newSimakFeatureRequests = SimakFeatureRequest::where('status', 'new')->count();

        $totalFeederSyncRequests = FeederSyncRequest::count();
        $pendingFeederSyncRequests = FeederSyncRequest::where('status', 'pending')->count();

        // Mengambil jumlah pengumuman (menggunakan model Announcement yang benar)
        $totalAnnouncements = Announcement::count();
        $publishedAnnouncements = Announcement::where('published_at', '<=', now())->count();


        return view('admin.dashboard', compact(
            'totalDataRequests', 'pendingDataRequests',
            'totalErrorReports', 'newErrorReports',
            'totalComplaints', 'pendingComplaints',
            'totalSimakFeatureRequests', 'newSimakFeatureRequests',
            'totalFeederSyncRequests', 'pendingFeederSyncRequests',
            'totalAnnouncements', 'publishedAnnouncements'
        ));
    }
}

