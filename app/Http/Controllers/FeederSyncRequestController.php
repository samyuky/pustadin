<?php

namespace App\Http\Controllers;

use App\Models\FeederSyncRequest; // Pastikan Anda memiliki model FeederSyncRequest
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan ID admin yang login

class FeederSyncRequestController extends Controller
{
    // Metode untuk menampilkan form pembuatan permintaan sinkronisasi feeder (untuk user umum)
    public function create()
    {
        return view('feeder_sync_requests.create');
    }

    // Metode untuk menyimpan permintaan sinkronisasi feeder yang baru dibuat
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'request_type' => 'required|string|max:255',
            'description' => 'required|string',
            'requester_phone' => 'nullable|string|max:20', // Tambahkan jika ada di form
        ]);

        FeederSyncRequest::create([
            'requester_name' => $validatedData['name'],
            'requester_email' => $validatedData['email'],
            'request_type' => $validatedData['request_type'],
            'description' => $validatedData['description'],
            'requester_phone' => $validatedData['requester_phone'] ?? null, // Sesuaikan jika ada di form
            'status' => 'pending', // Status awal
            'admin_id' => null, // Admin ID akan diisi saat admin mengelola
        ]);

        return redirect()->back()->with('success', 'Permintaan sinkronisasi feeder Anda telah berhasil diajukan!');
    }

    // Metode untuk menampilkan daftar permintaan sinkronisasi feeder (untuk admin)
    public function index()
    {
        $feederSyncRequests = FeederSyncRequest::latest()->paginate(10);
        return view('admin.feeder_sync_requests.index', compact('feederSyncRequests'));
    }

    // Metode untuk menampilkan detail permintaan sinkronisasi feeder (untuk admin)
    public function show(FeederSyncRequest $feederSyncRequest)
    {
        return view('admin.feeder_sync_requests.show', compact('feederSyncRequest'));
    }

    // Metode untuk memperbarui status permintaan sinkronisasi feeder (untuk admin)
    public function updateStatus(Request $request, FeederSyncRequest $feederSyncRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $feederSyncRequest->status = $request->status;
        $feederSyncRequest->admin_id = Auth::guard('admin')->id(); // Catat admin yang mengubah status
        $feederSyncRequest->save();

        return redirect()->route('admin.feeder-sync-requests.show', $feederSyncRequest->id)
                         ->with('success', 'Status permintaan sinkronisasi feeder berhasil diperbarui.');
    }

    // Metode untuk menghapus permintaan sinkronisasi feeder (untuk admin)
    public function destroy(FeederSyncRequest $feederSyncRequest)
    {
        try {
            $feederSyncRequest->delete();
            return redirect()->route('admin.feeder-sync-requests.index')
                             ->with('success', 'Permintaan sinkronisasi feeder berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.feeder-sync-requests.index')
                             ->with('error', 'Gagal menghapus permintaan sinkronisasi feeder: ' . $e->getMessage());
        }
    }
}
