<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaxInfo;
use App\Models\PaxMember;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemNotif;
use App\Models\GuideInfo;
use App\Models\HikingAct;
use App\Models\CancelReq;
use App\Models\ReschedHike;
use App\Models\TimeIn;
use App\Models\TimeOut;

class HomeControl extends Controller
{
    public function hiking_reg()
    {
        return view('hike-registration');
    }

    public function hikingreg_post(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'groupSize' => 'required|integer|min:1',
            'date' => 'required|date',
            'groupMembers.*.name' => 'required|string|max:255',
            'groupMembers.*.age' => 'required|integer|min:0',
            'groupMembers.*.gender' => 'required|string|max:50',
            'terms' => 'accepted',
            'activities' => 'required|integer', // Add validation for activities
        ]);
    
        try {
            // Log the request data
            Log::info('Request Data: ', $request->all());
    
            // Get the authenticated hiker's ID
            $hikerId = Auth::guard('hiker')->user()->hiker_id;
            $paxDate = strtotime($request->input('date'));
    
            // Create PaxInfo
            $paxInfo = PaxInfo::create([
                'pax_name' => strtoupper(substr(Auth::guard('hiker')->user()->first_name, 0, 2)) . '-' . date('d', $paxDate) . substr(date('Y', $paxDate), -2) . '-' .  ($request->input('groupSize') + 1),
                'pax_count' => $request->input('groupSize') + 1,
                'hike_date' => $request->input('date'),
                'status' => 'No Status',
                'hiker_id' => $hikerId, // Add hiker_id to PaxInfo
                'act_id' => $request->input('activities'), // Store the activity ID
            ]);
    
            // Store the main hiker's information
            PaxMember::create([
                'member_name' => $request->input('name'),
                'age' => $request->input('age'), // Assuming age is part of the request for the main hiker
                //'gender' => '', // Assuming gender is not provided for the main hiker, you can modify this as needed
                'pax_info_id' => $paxInfo->pax_id,
            ]);
    
            // Check if groupMembers is set and is an array
            $groupMembers = $request->input('groupMembers');
            if (is_array($groupMembers)) {
                // Create PaxMembers for each group member
                foreach ($groupMembers as $member) {
                    PaxMember::create([
                        'member_name' => $member['name'],
                        'age' => $member['age'],
                        'gender' => $member['gender'],
                        'pax_info_id' => $paxInfo->pax_id,
                    ]);
                }
            }
    
            return redirect()->back()->with('success', 'Hike registration sent successfully!');
        } catch (\Exception $e) {
            // Log the error message
            Log::error('Error in hikingreg_post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an issue with your registration.');
        }
    }
    


    public function accept_hiking_reg(Request $request, $id)
    {
        $guideId = session('guide_id'); 
        $paxInfo = PaxInfo::find($id);
    
        if ($paxInfo) {
            $paxInfo->status = 'Pending';
            $paxInfo->guide_id = $guideId;
            $paxInfo->save();
    
            // Assuming you have a GuideInfo model and it has the fields last_name and first_name
            $guideInfo = GuideInfo::find($guideId);
    
            if ($guideInfo) {
                $guideName = $guideInfo->first_name . ' ' . $guideInfo->last_name;
    
                // Create a notification for the hiker
                SystemNotif::create([
                    'hiker_id' => $paxInfo->hiker_id,
                    'notification' => "Your registration has been accepted by Guide Name: $guideName."
                ]);
    
                return redirect()->back()->with('status', 'Hiker registration accepted and notified.');
            } else {
                return redirect()->back()->with('error', 'Guide information not found.');
            }
        }
    
        return redirect()->back()->with('error', 'Hiker registration not found.');
    }
    
    public function getPaxMembers($id)
    {
        $members = PaxMember::where('pax_info_id', $id)->get();
        return response()->json($members);
    }

    public function cancel_hiking_reg(Request $request, $id)
{
    // Find the record by ID and update its status
    $record = PaxInfo::find($id);
    if ($record) {
        $record->status = 'No Status';
        $record->guide_id = session('guide_id'); // Set the guide_id to the logged-in guide's ID
        $record->save();

        // Set a session flash message
        return redirect()->back()->with('status', 'Registration Canceled!');
    } else {
        return redirect()->back()->with('status', 'Registration not found.');
    }
}

public function cancelHike(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|integer|exists:pax_info,pax_id',
                'reason' => 'required|string|max:1000',
            ]);

            // Create a new cancellation request
            $cancellation = new CancelReq();
            $cancellation->reason = $request->reason;
            $cancellation->status = 'For Review';
            $cancellation->created_at = now();
            $cancellation->pax_info_id = $request->id;
            $cancellation->save();

            // Update the status of the PaxInfo record
            $paxInfo = PaxInfo::find($request->id);
            $paxInfo->status = 'Under Review';
            $paxInfo->save();

            return response()->json(['message' => 'Cancellation request sent successfully!'], 200);
        } catch (\Exception $e) {
            Log::error('Error cancelling hike: ' . $e->getMessage());
            return response()->json(['message' => 'There was an error cancelling your hike.'], 500);
        }
    }
    public function fetchGuideInfo(Request $request)
    {
        $guideId = $request->get('guide_id');
        $guide = GuideInfo::find($guideId);

        if ($guide) {
            return response()->json([
                'success' => true,
                'guide' => $guide
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Guide not found'
            ]);
        }
    }

    public function rescheduleHike(Request $request)
{
    $request->validate([
        'id' => 'required|exists:pax_info,pax_id',
        'new_date' => 'required|date'
    ]);

    $hike = PaxInfo::find($request->id);

    if ($hike->status == 'No Status') {
        $hike->hike_date = $request->new_date;
        $hike->save();
        return response()->json(['message' => 'Hike rescheduled successfully.', 'status' => 'rescheduled']);
    } elseif ($hike->status == 'Pending') {
        $hike->status = 'Reschedule on review';
        $hike->save();

        // Store the reschedule request
        ReschedHike::create([
            'resched_date' => $request->new_date,
            'pax_id' => $hike->pax_id
        ]);

        return response()->json(['message' => 'Reschedule request is under review.', 'status' => 'reschedule_review']);
    } else {
        return response()->json(['message' => 'Invalid status for rescheduling.', 'status' => 'error'], 400);
    }
}

public function time_in(Request $request)
{
  // Validate the incoming request data
  $request->validate([
    'time' => 'required|string',
    'pax_id' => 'required|integer|exists:pax_info,pax_id',
]);

try {
    // Create a new TimeIn record
    TimeIn::create([
        'time' => $request->input('time'),
        'pax_id' => $request->input('pax_id'),
    ]);

    return response()->json(['success' => true], 200);
} catch (\Exception $e) {
    // Log the error details to laravel.log
    Log::error('Failed to record time-in:', [
        'error' => $e->getMessage(),
        'pax_id' => $request->input('pax_id'),
        'time' => $request->input('time'),
    ]);

    // Return a JSON response indicating failure
    return response()->json([
        'success' => false,
        'message' => 'Failed to record the time. Please try again later.',
    ], 500);
}
}

public function time_out(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'time' => 'required|string',
        'pax_id' => 'required|integer|exists:pax_info,pax_id',
    ]);

    try {
        // Create a new TimeOut record
        TimeOut::create([
            'time' => $request->input('time'),
            'pax_id' => $request->input('pax_id'),
        ]);

        return response()->json(['success' => true], 200);
    } catch (\Exception $e) {
        // Log the error details to laravel.log
        Log::error('Failed to record time-out:', [
            'error' => $e->getMessage(),
            'pax_id' => $request->input('pax_id'),
            'time' => $request->input('time'),
        ]);

        // Return a JSON response indicating failure
        return response()->json([
            'success' => false,
            'message' => 'Failed to record the time. Please try again later.',
        ], 500);
    }
}

public function hike_completed(Request $request)
{
    // Validate the incoming request data
    $request->validate([
        'pax_id' => 'required|integer|exists:pax_info,pax_id',
        'status' => 'required|string',
    ]);

    try {
        // Find the PaxInfo record
        $paxInfo = PaxInfo::findOrFail($request->input('pax_id'));
        // Update the status
        $paxInfo->status = $request->input('status');
        $paxInfo->save();

        return response()->json(['success' => true], 200);
    } catch (\Exception $e) {
        // Log the error details to laravel.log
        Log::error('Failed to update status:', [
            'error' => $e->getMessage(),
            'pax_id' => $request->input('pax_id'),
            'status' => $request->input('status'),
        ]);

        // Return a JSON response indicating failure
        return response()->json([
            'success' => false,
            'message' => 'Failed to update the status. Please try again later.',
        ], 500);
    }
}
}
