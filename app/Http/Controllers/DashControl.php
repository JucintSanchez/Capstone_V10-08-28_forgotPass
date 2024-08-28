<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use App\Models\Admin;
use App\Models\HikerInfo;
use App\Models\GuideInfo;
use App\Models\tourist_spot;
use App\Models\HikingAct;
use App\Models\CancelReq;
use App\Models\PaxInfo;
use App\Models\PaxMember;
use App\Models\TimeIn;
use App\Models\TimeOut;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DashControl extends Controller
{
    // app/Http/Controllers/GuideController.php

public function accept_guide(Request $request)
    {
        $guide = GuideInfo::find($request->guide_id);
        if ($guide) {
            $guide->status = 'Accepted';
            $guide->save(); 

            return back()->with('message', 'Tourist Guide Accepted!');
        }

        return back()->with('error', 'Guide not Found!');
    }

public function table()
{
    $guides = GuideInfo::all();
    return view('LandingPage.dashboard_records.guide_application', compact('guides'))->render();
}

public function reject_guide(Request $request)
    {
        $guide = GuideInfo::find($request->guide_id);
        $guide->status = 'Rejected';
        $guide->save();

        return response()->json(['message' => 'Guide rejected successfully.']);
    }


    public function spot_post(Request $request)
    {
        // Validate the form input
        $request->validate([
            'desc' => 'required|string',
            'spot_img.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    
        $imagePaths = [];
    
        if ($request->hasFile('spot_img')) {
            foreach ($request->file('spot_img') as $file) {
                $path = $file->store('spot_img', 'public');
                $imagePaths[] = $path;
            }
        } else {
            // Handle the case where the file is not present, although it's required
            return response()->json(['message' => 'Images are required'], 422);
        }
    
        // Save the paths as a JSON-encoded array
        $paths = json_encode($imagePaths);
    
        // guide registration
        tourist_spot::create([
            'desc' => $request->desc,
            'images' => $paths, // Save the JSON-encoded paths
            // 'org_id' => $request->org_id, // Assuming org_id is being passed from the form
        ]);
    
        // Redirect to a success page or login
        return response()->json(['message' => 'Posted Successfully']);
    }
    
    public function viewPosts()
    {
        $spots = tourist_spot::paginate(5);
        if ($request->ajax()) {
            return view('LandingPage.spot_view', compact('spots'))->render();
        }
        return view('LandingPage.spot_view', compact('spots'));
    }

    public function add_hike_act(Request $request)
{
    $validatedData = $request->validate([
        'act_name' => 'required|string',
        'desc' => 'required|string',
        'act_img.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $imagePaths = [];
    if ($request->hasFile('act_img')) {
        foreach ($request->file('act_img') as $image) {
            $path = $image->store('public/act_img');
            $imagePaths[] = $path;
        }
    }

    $activity = new HikingAct([
        'act_name' => $validatedData['act_name'],
        'desc' => $validatedData['desc'],
        'act_picture' => json_encode($imagePaths),
    ]);

    if ($activity->save()) {
        return response()->json(['message' => 'Activity added successfully']);
    } else {
        return response()->json(['message' => 'Failed to add activity'], 500);
    }
}

    public function acts(Request $request)
{
    $acts = HikingAct::orderBy('activity_id', 'desc')->paginate(5);
    return view('LandingPage.Hiking_Act.hiking_acts', compact('acts'))->render();
}

public function del_acts($id)
    {
        try {
            $activity = HikingAct::findOrFail($id);
            // Perform authorization check here if required
    
            $activity->delete();
    
            return response()->json(['message' => 'Activity deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete activity'], 500);
        }
    }

    
    public function show_act($id)
        {
            // $activity = HikingAct::findOrFail($id);

            // // Assuming 'act_picture' is stored as JSON in the database
            // $activity->act_picture = json_decode($activity->act_picture);

            // return response()->json($activity);
            Log::info('Fetching activity with ID: ' . $id);
            try {
                $activity = HikingAct::find($id);
                if (!$activity) {
                    return response()->json(['success' => false, 'message' => 'Activity not found'], 404);
                }
                // Decode the JSON stored images
                $activity->act_picture = json_decode($activity->act_picture);
                return response()->json($activity);
            } catch (\Exception $e) {
                Log::error('Error fetching activity: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Internal server error'], 500);
            }
        }
 
    public function update(Request $request, $id)
    {
        \Log::info('Starting update process for activity with ID: ' . $id);
    
        try {
            $activity = HikingAct::findOrFail($id);
            \Log::info('Activity found:', ['activity' => $activity]);
    
            // Validate incoming request
            $validatedData = $request->validate([
                'updt_act_name' => 'required|string|max:255',
                'updt_desc' => 'required|string',
                'updt_act_img.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            \Log::info('Request validated:', $validatedData);
    
            // Update activity details
            $activity->act_name = $request->updt_act_name;
            $activity->desc = $request->updt_desc;
            \Log::info('Activity details updated:', ['name' => $activity->act_name, 'desc' => $activity->desc]);
    
            // Handle file uploads
            if ($request->hasFile('updt_act_img')) {
                \Log::info('Handling file uploads');
    
                // Log the uploaded files
                foreach ($request->file('updt_act_img') as $file) {
                    \Log::info('Uploaded file:', ['originalName' => $file->getClientOriginalName(), 'path' => $file->getPathname()]);
                }
    
                // Remove old images
                $oldImages = json_decode($activity->act_picture, true);
                if ($oldImages) {
                    \Log::info('Removing old images:', ['oldImages' => $oldImages]);
                    foreach ($oldImages as $oldImage) {
                        Storage::delete($oldImage);
                    }
                }
    
                $images = [];
                foreach ($request->file('updt_act_img') as $file) {
                    $path = $file->store('public/activities');
                    \Log::info('File stored:', ['path' => $path]);
                    $images[] = $path;
                }
                // Update the act_picture field with the new images
                $activity->act_picture = json_encode($images);
                \Log::info('Activity images updated:', ['images' => $images]);
            } else {
                \Log::info('No new images uploaded');
            }
    
            // Save updated activity
            $activity->save();
            \Log::info('Activity saved successfully.');
    
            return response()->json(['message' => 'Activity updated successfully!'], 200);
        } catch (\Exception $e) {
            \Log::error('Error updating activity:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['message' => 'An error occurred while updating the activity.', 'error' => $e->getMessage()], 500);
        }
    }

    public function approve($id)
{
    $cancellation = CancelReq::find($id);
    $cancellation->status = 'Approved';
    $cancellation->save();

    // Update the status of the PaxInfo record
    $paxInfo = PaxInfo::find($cancellation->pax_info_id);
    if ($paxInfo) {
        $paxInfo->status = 'Cancelled';
        $paxInfo->save();
    }

    return redirect()->back()->with('success', 'Cancellation request approved.');
}


public function decline($id)
{
    $cancellation = CancelReq::find($id);
    $cancellation->status = 'Declined';
    $cancellation->save();

    // Update the status of the PaxInfo record based on guide_id
    $paxInfo = PaxInfo::find($cancellation->pax_info_id);
    if ($paxInfo) {
        if ($paxInfo->guide_id) {
            $paxInfo->status = 'Pending';
        } else {
            $paxInfo->status = 'No Status';
        }
        $paxInfo->save();
    }

    return redirect()->back()->with('success', 'Cancellation request declined.');
}

public function verify(Request $request)
    {
        $request->validate([
            'pax_id' => 'required|exists:pax_info,pax_id',
        ]);

        $paxId = $request->input('pax_id');

        $paxInfo = PaxInfo::find($paxId);
        if (!$paxInfo) {
            return response()->json(['success' => false, 'message' => 'PaxInfo not found']);
        }

        $paxInfo->status = 'Ongoing';
        $paxInfo->save();

        return response()->json(['success' => true]);
    }

    public function getHikeDetails(Request $request)
    {
        $paxId = $request->input('pax_id');
        $paxInfo = PaxInfo::find($paxId);
        if (!$paxInfo) {
            return response()->json(['error' => 'Hike not found'], 404);
        }

        $leader = HikerInfo::find($paxInfo->hiker_id);
        $members = PaxMember::where('pax_info_id', $paxId)->get();
        $guide = GuideInfo::find($paxInfo->guide_id); // Assuming PaxInfo has a guide_id field
        $timeIn = TimeIn::where('pax_id', $paxId)->first();
        $timeOut = TimeOut::where('pax_id', $paxId)->first();


        return response()->json([
            'leaderName' => $leader->first_name . ' ' . $leader->last_name,
            'memberNames' => $members->pluck('member_name')->join(', '),
            'hikeDate' => $paxInfo->hike_date,
            'guideName' => $guide->first_name . ' ' . $guide->last_name,
            'timeIn' => $timeIn ? $timeIn->time : 'N/A', // Fetch timeIn from TimeIn model
            'timeOut' => $timeOut ? $timeOut->time : 'N/A',
        ]);
    }
}

    
    

