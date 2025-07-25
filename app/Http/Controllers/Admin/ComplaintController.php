<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement; 
use App\Models\BulletinBoardAnnouncement; 
use App\Mail\ComplaintStatusUpdated;
use Illuminate\Support\Facades\Mail;

class ComplaintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Menampilkan daftar semua keluhan.
     */
    public function index()
    {
        $complaints = Complaint::latest()->paginate(10);
        return view('admin.complaints.index', compact('complaints'));
    }

    /**
     * Menampilkan detail keluhan tertentu.
     */
    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $complaint->status = $request->status;
        $complaint->admin_id = Auth::guard('admin')->id();
        $complaint->save();

        return redirect()->route('admin.error-reports.show', $complaint->id)
                         ->with('success', 'Status laporan error berhasil diperbarui.');
    }

    public function updateStatus(Request $request, $id, SimakFeatureRequest $simakFeatureRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed'
        ]);

        $simakFeatureRequest->update([
            'status' => $request->status,
            'admin_id' => auth()->id() // Jika perlu track admin yang mengupdate
        ]);
        $complaint = Complaint::findOrFail($id);
        $newStatus = $request->status;
        
        try {
            Mail::to($complaint->complainant_email)
                ->send(new ComplaintStatusUpdated($complaint, $newStatus));
            
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'email_sent' => 'Email terkirim ke ' . $complaint->complainant_email
            ]);
            
        } catch (\Exception $e) {
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'warning' => 'Email gagal dikirim: ' . $e->getMessage()
            ]);
        }
        \Log::debug('Update Status Request', [
            'request' => $request->all(),
            'current_status' => $simakFeatureRequest->status
        ]);
    }   

    public function build()
    {
        return $this->subject('Status Keluhan Diperbarui')
                ->view('emails.complaint_status_updated', [
                    'status' => $this->status,
                    'complaint' => $this->complaint
                ]);
    }
    public function destroy(Complaint $complaint)
    {
        try {
            $complaint->delete();
            return redirect()->route('admin.complaints.index')->with('success', 'Keluhan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.complaints.index')->with('error', 'Gagal menghapus keluhan: ' . $e->getMessage());
        }
    }
}
