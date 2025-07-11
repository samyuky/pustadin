<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorReport; // Pastikan Anda memiliki model ErrorReport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan ID admin yang login

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
    public function updateStatus(Request $request, ErrorReport $errorReport)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $errorReport->status = $request->status;
        $errorReport->admin_id = Auth::guard('admin')->id(); // Catat admin yang mengubah status
        $errorReport->save();

        return redirect()->route('admin.error-reports.show', $errorReport->id)
                         ->with('success', 'Status laporan error berhasil diperbarui.');
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