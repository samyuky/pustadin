<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeederSyncRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FeederSyncRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Menampilkan daftar semua permintaan sinkronisasi Feeder.
     */
    public function index()
    {
        $feederSyncRequests = FeederSyncRequest::latest()->paginate(10);
        return view('admin.feeder-sync-requests.index', compact('feederSyncRequests'));
    }

    /**
     * Menampilkan detail permintaan sinkronisasi Feeder tertentu.
     */
    public function show(FeederSyncRequest $feederSyncRequest)
    {
        // DEBUGGING: Periksa apakah model FeederSyncRequest berhasil di-bind
        // Jika Anda mendapatkan 404 saat mengakses halaman show, dd() ini tidak akan terpanggil.
        // Jika halaman show berhasil dimuat, Anda akan melihat data model di sini.
        // dd($feederSyncRequest); 
        
        return view('admin.feeder-sync-requests.show', compact('feederSyncRequest'));
    }

    /**
     * Memperbarui permintaan sinkronisasi Feeder (termasuk status dan catatan resolusi).
     */
    public function update(Request $request, FeederSyncRequest $feederSyncRequest)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'requester_name' => 'required|string|max:255',
            'requester_email' => 'required|email|max:255',
            'status' => 'required|in:pending,processing,completed,failed',
            'resolution_notes' => 'nullable|string',
        ]);

        $feederSyncRequest->update($validatedData);
        $feederSyncRequest->admin_id = Auth::guard('admin')->id();
        $feederSyncRequest->save();

        return redirect()->route('admin.feeder-sync-requests.show', $feederSyncRequest->id)
                         ->with('success', 'Permintaan sinkronisasi Feeder berhasil diperbarui.');
    }

    /**
     * Metode khusus untuk memperbarui status saja.
     */
    public function updateStatus(Request $request, FeederSyncRequest $feederSyncRequest)
    {
        // DEBUGGING: Periksa apakah model FeederSyncRequest berhasil di-bind saat update
        // Jika Anda mendapatkan 404 saat mengirim form update, dd() ini tidak akan terpanggil.
        // Jika terpanggil, Anda akan melihat data model yang sedang diupdate.
        // dd($feederSyncRequest, $request->all()); 

        // Pastikan $feederSyncRequest berhasil di-bind (tidak null)
        if (!$feederSyncRequest) {
            return redirect()->route('admin.feeder-sync-requests.index')->with('error', 'Permintaan sinkronisasi Feeder tidak ditemukan.');
        }

        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed',
            'resolution_notes' => 'nullable|string',
        ]);

        $feederSyncRequest->status = $request->status;
        $feederSyncRequest->admin_id = Auth::guard('admin')->id();
        $feederSyncRequest->resolution_notes = $request->resolution_notes;
        
        // Atur resolved_at jika status menjadi 'completed'
        if ($feederSyncRequest->status === 'completed' && is_null($feederSyncRequest->resolved_at)) {
            $feederSyncRequest->resolved_at = Carbon::now();
        } elseif ($feederSyncRequest->status !== 'completed') {
            $feederSyncRequest->resolved_at = null;
        }

        $feederSyncRequest->save();

        return redirect()->route('admin.feeder-sync-requests.show', $feederSyncRequest->id)
                         ->with('success', 'Status permintaan sinkronisasi Feeder berhasil diperbarui.');
    }

    /**
     * Menghapus permintaan sinkronisasi Feeder.
     */
    public function destroy(FeederSyncRequest $feederSyncRequest)
    {
        try {
            $feederSyncRequest->delete();
            return redirect()->route('admin.feeder-sync-requests.index')->with('success', 'Permintaan sinkronisasi Feeder berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.feeder-sync-requests.index')->with('error', 'Gagal menghapus permintaan: ' . $e->getMessage());
        }
    }
}
