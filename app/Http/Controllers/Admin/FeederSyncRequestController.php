<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeederSyncRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\FeederSyncRequestStatusUpdated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class FeederSyncRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $feederSyncRequests = FeederSyncRequest::latest()->paginate(10);
        return view('admin.feeder-sync-requests.index', compact('feederSyncRequests'));
    }

    public function show(FeederSyncRequest $feederSyncRequest)
    {
        return view('admin.feeder-sync-requests.show', compact('feederSyncRequest'));
    }

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

        $feederSyncRequest->update(array_merge($validatedData, [
            'admin_id' => Auth::guard('admin')->id()
        ]));

        return redirect()->route('admin.feeder-sync-requests.show', $feederSyncRequest)
                       ->with('success', 'Permintaan sinkronisasi Feeder berhasil diperbarui.');
    }

    public function updateStatus(Request $request, FeederSyncRequest $feederSyncRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,failed',
            'resolution_notes' => 'nullable|string'
        ]);

        $newStatus = $request->status;
        
        // Update status, resolution_notes dan admin_id
        $feederSyncRequest->update([
            'status' => $newStatus,
            'resolution_notes' => $request->resolution_notes,
            'admin_id' => Auth::guard('admin')->id()
        ]);

        try {
            Log::info("Mengirim email status ke: {$feederSyncRequest->requester_email}");
            
            Mail::to($feederSyncRequest->requester_email)
                ->send(new FeederSyncRequestStatusUpdated($feederSyncRequest, $newStatus));
                
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'email_sent' => 'Email terkirim ke ' . $feederSyncRequest->requester_email
            ]);
            
        } catch (\Exception $e) {
            Log::error("Gagal mengirim email: " . $e->getMessage());
            
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'warning' => 'Email gagal dikirim: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(FeederSyncRequest $feederSyncRequest)
    {
        try {
            $feederSyncRequest->delete();
            return redirect()->route('admin.feeder-sync-requests.index')
                           ->with('success', 'Permintaan sinkronisasi Feeder berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.feeder-sync-requests.index')
                           ->with('error', 'Gagal menghapus permintaan: ' . $e->getMessage());
        }
    }
}