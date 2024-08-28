<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSettings;
use App\Models\Organization;
use App\Models\MountainDetails;
use App\Models\ThingsToBring;
use App\Models\Rules_Regulation;
use App\Models\TermsCondition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class HomeSettingsController extends Controller
{
    public function update_aboutus(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if (!$admin) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $org_id = $admin->org_id;
        if (!$org_id) {
            return redirect()->back()->with('error', 'Organization not found.');
        }

        // Validate the request
        $request->validate([
            'landingPagePhoto' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'aboutUs' => 'string',
            'contactNumber' => 'nullable|string',
            'contactEmail' => 'nullable|email',
            'mountain_name' => 'string|max:255',  // Change made here
            'difficulty' => 'string|max:255',
            'elevation' => 'string|max:255',
            'station' => 'string|max:255',
            'features' => 'nullable|string',
            'overview' => 'nullable|string',
        ]);

        // Handle the photo upload
        $data = [
            'about_us' => $request->aboutUs,
            'contact_num' => $request->contactNumber,
            'email' => $request->contactEmail,
            'org_id' => $org_id,
        ];

        if ($request->hasFile('landingPagePhoto')) {
            $image = $request->file('landingPagePhoto');
            $imageName = time().'.'.$image->extension();
            $image->move(public_path('images'), $imageName);
            $data['landing_photo'] = $imageName;
        }

        // Update or create home settings for the organization 
        HomeSettings::updateOrCreate(
            ['org_id' => $org_id],
            $data
        );

        // Update or create mountain details
        MountainDetails::updateOrCreate(
            ['org_id' => $org_id],
            [
                'mountain_name' => $request->mountain_name,  // Change made here
                'difficulty' => $request->difficulty,
                'elevation' => $request->elevation,
                'station' => $request->station,
                'features' => $request->features,
                'overview' => $request->overview,
            ]
        );

        return response()->json(['status' => 'success', 'message' => 'Home page updated successfully!.']);
    }

    public function add_items(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id ?? null;

        if ($org_id) {
            ThingsToBring::create([
                'item_name' => $request->input('item_name'),
                'org_id' => $org_id,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Added things to bring successfully!.']);
    }

    public function delete_items($id)
    {
        $item = ThingsToBring::findOrFail($id);
        $item->delete();

        return response()->json(['status' => 'success', 'message' => 'Item removed successfully!.']);
    }

    public function add_rules(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id ?? null;

        if ($org_id) {
            Rules_Regulation::create([
                'rules_n_regulation' => $request->input('rules_n_regulation'),
                'org_id' => $org_id,
            ]);
        }

        return response()->json(['status' => 'success', 'message' => 'Rules and regulation added successfully!.']);
    }

    public function delete_rules($id)
    {
        $rule = Rules_Regulation::findOrFail($id);
        $rule->delete();

        return response()->json(['status' => 'success', 'message' => 'Rules and regulation deleted successfully!.']);
    }

    public function terms_n_condition(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id ?? null;

        if ($org_id) {
            TermsCondition::updateOrCreate(
                ['org_id' => $org_id], // Condition to check if it exists
                ['terms_and_condition' => $request->input('terms_and_condition')] // Data to update or create
            );
        }

        return response()->json(['status' => 'success', 'message' => 'Terms and condition updated successfully!.']);
    }
    }

    