<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon; // Pastikan Carbon diimport

class BulletinBoardAnnouncementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Menampilkan daftar semua pengumuman dan keluhan yang relevan.
     */
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);

        $respondedComplaints = Complaint::whereIn('status', ['approved', 'rejected', 'completed'])
                                        ->latest()
                                        ->paginate(10, ['*'], 'complaintPage');

        return view('admin.announcements.index', compact('announcements', 'respondedComplaints'));
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
            'published_at' => 'nullable|date', // Tetap nullable di validasi
        ]);

        // Logika untuk mengatur published_at
        // Jika published_at kosong, set ke waktu sekarang (langsung publikasi)
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

        // Logika untuk mengatur published_at saat update
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
