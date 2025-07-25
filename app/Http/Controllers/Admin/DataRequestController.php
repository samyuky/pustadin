<?php

namespace App\Http\Controllers\Admin; 

use App\Http\Controllers\Controller;
use App\Models\DataRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\DataRequestStatusUpdated;
use Illuminate\Support\Facades\Mail;



class DataRequestController extends Controller
{
    /**
     * Display a listing of the data requests.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $dataRequests = DataRequest::latest()->paginate(10);
        return view('admin.data_requests.index', compact('dataRequests'));
    }

    /**
     * Display the specified data request.
     *
     * @param  \App\Models\DataRequest  $dataRequest
     * @return \Illuminate\View\View
     */
    public function show(DataRequest $dataRequest)
    {
        return view('admin.data_requests.show', compact('dataRequest'));
    }

    /**
     * Update the status of the specified data request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DataRequest  $dataRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $dataRequest = DataRequest::findOrFail($id);
        $newStatus = $request->status;
        
        try {
            Mail::to($dataRequest->requester_email)
                ->send(new DataRequestStatusUpdated($dataRequest, $newStatus)); // Kirim kedua parameter
            
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'email_sent' => 'Email terkirim ke ' . $dataRequest->requester_email
            ]);
            
        } catch (\Exception $e) {
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'warning' => 'Email gagal dikirim: ' . $e->getMessage()
            ]);
        }

                try {
            \Log::info("Mengirim email ke: " . $dataRequest->requester_email);
            Mail::to($dataRequest->requester_email)
                ->send(new DataRequestStatusUpdated($dataRequest, $newStatus));
            \Log::info("Email berhasil dikirim");
            // ...
        } catch (\Exception $e) {
            \Log::error("Error mengirim email: " . $e->getMessage());
            // ...
        }
    }

    public function build()
    {
        return $this->subject('Status Permintaan Data Diperbarui')
                ->view('emails.data_request_status_updated', [
                    'status' => $this->status,
                    'dataRequest' => $this->dataRequest
                ]);
    }

    /**
     * Remove the specified data request from storage.
     *
     * @param  \App\Models\DataRequest  $dataRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DataRequest $dataRequest)
    {
        if ($dataRequest->attachment_path) {
            Storage::delete($dataRequest->attachment_path);
        }
        $dataRequest->delete();

        return redirect()->route('admin.data-requests.index')
                         ->with('success', 'Permintaan data berhasil dihapus.');
    }
}