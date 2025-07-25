<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimakFeatureRequest; 
use Illuminate\Http\Request;
use App\Mail\SimakFeatureRequestStatusUpdated;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SimakFeatureRequestController extends Controller
{
    public function index()
    {
        $simakFeatureRequests = SimakFeatureRequest::latest()->paginate(10);
        return view('admin.simak_feature_requests.index', compact('simakFeatureRequests'));
    }

    public function show(SimakFeatureRequest $simakFeatureRequest)
    {
        return view('admin.simak_feature_requests.show', compact('simakFeatureRequest'));
    }

    public function updateStatus(Request $request, SimakFeatureRequest $simakFeatureRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $newStatus = $request->status;
        
        // Update status
        $simakFeatureRequest->update([
            'status' => $newStatus,
            'admin_id' => auth()->id()
        ]);

        try {
            Log::info("Mengirim email ke: " . $simakFeatureRequest->requester_email);
            
            Mail::to($simakFeatureRequest->requester_email)
                ->send(new SimakFeatureRequestStatusUpdated($simakFeatureRequest, $newStatus));
                
            Log::info("Email berhasil dikirim");
            
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'email_sent' => 'Email terkirim ke ' . $simakFeatureRequest->requester_email
            ]);
            
        } catch (\Exception $e) {
            Log::error("Error mengirim email: " . $e->getMessage());
            
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'warning' => 'Email gagal dikirim: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(SimakFeatureRequest $simakFeatureRequest)
    {
        try {
            $simakFeatureRequest->delete();
            return redirect()->route('admin.simak-feature-requests.index')
                            ->with('success', 'Permintaan fitur SIMAK berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.simak-feature-requests.index')
                            ->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }
}