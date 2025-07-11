<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeederSyncRequest; // Pastikan Anda memiliki model FeederSyncRequest
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan ID admin yang login

class FeederSyncRequestController extends Controller
{
    public function index()
    {
        $feederSyncRequests = FeederSyncRequest::latest()->paginate(10);
        return view('admin.feeder_sync_requests.index', compact('feederSyncRequests'));
    }

    public function show(FeederSyncRequest $feederSyncRequest)
    {
        return view('admin.feeder_sync_requests.show', compact('feederSyncRequest'));
    }

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