<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SimakFeatureRequest; // Pastikan Anda memiliki model SimakFeatureRequest
use Illuminate\Http\Request;

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
            'status' => 'required|in:pending,approved,rejected,completed',
        ]);

        $simakFeatureRequest->status = $request->status;
        $simakFeatureRequest->save();

        return redirect()->route('admin.simak-feature-requests.show', $simakFeatureRequest->id)
                         ->with('success', 'Status permintaan fitur SIMAK berhasil diperbarui.');
    }

    public function destroy(SimakFeatureRequest $simakFeatureRequest)
    {
        $simakFeatureRequest->delete();
        return redirect()->route('admin.simak-feature-requests.index')
                         ->with('success', 'Permintaan fitur SIMAK berhasil dihapus.');
    }
}