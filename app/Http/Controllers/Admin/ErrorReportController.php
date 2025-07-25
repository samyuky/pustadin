<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorReport; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Mail\ErrorReportStatusUpdated;
use Illuminate\Support\Facades\Mail;

class ErrorReportController extends Controller
{
    /**
     * Display a listing of the error reports.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua laporan error dengan paginasi
        $errorReports = ErrorReport::latest()->paginate(10);
        return view('admin.error_reports.index', compact('errorReports'));
    }

    /**
     * Display the specified error report.
     *
     * @param  \App\Models\ErrorReport  $errorReport
     * @return \Illuminate\View\View
     */
    public function show(ErrorReport $errorReport)
    {
        return view('admin.error_reports.show', compact('errorReport'));
    }

    /**
     * Update the status of the specified error report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ErrorReport  $errorReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        $errorReport = ErrorReport::findOrFail($id);
        $newStatus = $request->status;
        
        try {
            Mail::to($errorReport->reporter_email)
                ->send(new ErrorReportStatusUpdated($errorReport, $newStatus)); // Kirim kedua parameter
            
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'email_sent' => 'Email terkirim ke ' . $errorReport->reporter_email
            ]);
            
        } catch (\Exception $e) {
            return back()->with([
                'success' => 'Status berhasil diperbarui',
                'warning' => 'Email gagal dikirim: ' . $e->getMessage()
            ]);
        }

                try {
            \Log::info("Mengirim email ke: " . $errorReport->reporter_email);
            Mail::to($errorReport->reporter_email)
                ->send(new ErrorReportStatusUpdated($errorReport, $newStatus));
            \Log::info("Email berhasil dikirim");
            // ...
        } catch (\Exception $e) {
            \Log::error("Error mengirim email: " . $e->getMessage());
            // ...
        }
    }

    public function build()
    {
        return $this->subject('Status Laporan Error Diperbarui')
                ->view('emails.error_report_status_updated', [
                    'status' => $this->status,
                    'errorReport' => $this->errorReport
                ]);
    }
    /**
     * Remove the specified error report from storage.
     *
     * @param  \App\Models\ErrorReport  $errorReport
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ErrorReport $errorReport)
    {
        try {
            $errorReport->delete();
            return redirect()->route('admin.error-reports.index')
                             ->with('success', 'Laporan error berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.error-reports.index')
                             ->with('error', 'Gagal menghapus laporan error: ' . $e->getMessage());
        }
    }
}