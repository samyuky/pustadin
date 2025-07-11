<?php

namespace App\Http\Controllers\Admin; // Pastikan namespace ini benar

use App\Http\Controllers\Controller;
use App\Models\DataRequest; // Pastikan Anda memiliki model DataRequest
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
    public function updateStatus(Request $request, DataRequest $dataRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $dataRequest->status = $request->status;
        $dataRequest->save();

        return redirect()->route('admin.data-requests.show', $dataRequest->id)
                         ->with('success', 'Status permintaan data berhasil diperbarui.');
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