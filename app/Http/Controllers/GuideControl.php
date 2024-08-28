<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaxInfo;
use App\Models\ReschedHike;
use Illuminate\Support\Facades\Log;

class GuideControl extends Controller
{
    public function approveReschedule(Request $request)
{
    $request->validate([
        'pax_id' => 'required|exists:pax_info,pax_id',
        'approve' => 'required|string'
    ]);

    try {
        $hike = PaxInfo::find($request->pax_id);
        $resched = ReschedHike::where('pax_id', $request->pax_id)->first();

        if ($hike && $resched) {
            $approve = filter_var($request->approve, FILTER_VALIDATE_BOOLEAN);

            if ($approve) {
                // Update hike date and status if approved
                $hike->hike_date = $resched->resched_date;
                $hike->status = 'Pending'; // Or any other status indicating approval
            } else {
                // Update hike date and status if rejected
                $hike->hike_date = $resched->resched_date;
                $hike->status = 'No Status';
                $hike->guide_id = null; // Set guide_id to null
            }

            $hike->save();
            $resched->delete();

            return response()->json(['message' => 'Reschedule request processed successfully.']);
        } else {
            Log::error('Reschedule request not found for pax_id: ' . $request->pax_id);
            return response()->json(['message' => 'Reschedule request not found.'], 404);
        }
    } catch (\Exception $e) {
        Log::error('Error processing reschedule request for pax_id: ' . $request->pax_id, ['exception' => $e]);
        return response()->json(['message' => 'An error occurred while processing the reschedule request.', 'error' => $e->getMessage()], 500);
    }
}
public function fetchReschedDate(Request $request)
{
    try {
        $request->validate([
            'pax_id' => 'required|exists:reschedule_req,pax_id'
        ]);

        $resched = ReschedHike::where('pax_id', $request->pax_id)->first();

        if ($resched) {
            return response()->json(['success' => true, 'requested_date' => $resched->resched_date]);
        } else {
            Log::error('Reschedule request not found for pax_id: ' . $request->pax_id);
            return response()->json(['success' => false, 'message' => 'Reschedule request not found.']);
        }
    } catch (\Exception $e) {
        Log::error('Error fetching reschedule date for pax_id: ' . $request->pax_id, ['exception' => $e]);
        return response()->json(['success' => false, 'message' => 'An error occurred while fetching the reschedule date.']);
    }
}
}
