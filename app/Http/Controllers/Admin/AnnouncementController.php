<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\DataRequest; 
use App\Models\ErrorReport; 
use App\Models\Complaint;   
use App\Models\SimakFeatureRequest; 
use App\Models\FeederSyncRequest; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        // Mengambil data pengumuman
        $announcements = Announcement::latest()->paginate(10, ['*'], 'announcementPage');

        // Mengambil data permintaan data, tidak termasuk 'pending'
        $dataRequests = DataRequest::where('status', '!=', 'pending')
                                   ->latest()
                                   ->paginate(10, ['*'], 'dataRequestPage');

        // Mengambil data laporan error, tidak termasuk 'new' ATAU 'pending'
        $errorReports = ErrorReport::whereNotIn('status', ['new', 'pending'])
                                   ->latest()
                                   ->paginate(10, ['*'], 'errorReportPage');

        // Mengambil data keluhan (yang sudah ditanggapi: approved, rejected, completed)
        // Status 'pending' sudah tidak termasuk di sini
        $complaints = Complaint::whereIn('status', ['approved', 'rejected', 'completed'])
                                ->latest()
                                ->paginate(10, ['*'], 'complaintPage');

        // Mengambil data permintaan fitur SIMAK, tidak termasuk 'new' ATAU 'pending'
        $simakFeatureRequests = SimakFeatureRequest::whereNotIn('status', ['new', 'pending'])
                                                    ->latest()
                                                    ->paginate(10, ['*'], 'simakFeaturePage');

        // Mengambil data permintaan sinkronisasi Feeder, tidak termasuk 'pending'
        $feederSyncRequests = FeederSyncRequest::where('status', '!=', 'pending')
                                                ->latest()
                                                ->paginate(10, ['*'], 'feederSyncPage');

        return view('admin.announcements.index', compact(
            'announcements',
            'dataRequests',
            'errorReports',
            'complaints',
            'simakFeatureRequests',
            'feederSyncRequests'
        ));
    }

    /**
     * Menampilkan form untuk membuat pengumuman baru.
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Menyimpan pengumuman baru.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        if (empty($validatedData['published_at'])) {
            $validatedData['published_at'] = Carbon::now();
        }

        Announcement::create($validatedData);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil ditambahkan dan dipublikasikan!');
    }

    /**
     * Menampilkan form untuk mengedit pengumuman.
     */
    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Memperbarui pengumuman.
     */
    public function update(Request $request, Announcement $announcement)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        if (empty($validatedData['published_at'])) {
            $validatedData['published_at'] = Carbon::now();
        }

        $announcement->update($validatedData);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui!');
    }

    /**
     * Menghapus pengumuman.
     */
    public function destroy(Announcement $announcement)
    {
        try {
            $announcement->delete();
            return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.announcements.index')->with('error', 'Gagal menghapus pengumuman: ' . $e->getMessage());
        }
    }
}
