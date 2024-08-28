<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use App\Models\Admin;
use App\Models\HikerInfo;
use App\Models\GuideInfo;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class capscontroller extends Controller
{
    public function home()
    {
        $user = Auth::guard('hiker')->user();
    $username = $user ? $user->username : 'Login/Register';

        return view('LandingPage.home',compact('username'));
    }

    public function login()
    {
        return view('LandingPage.login');
    }
    public function visitorLogin()
    {
        return view('LandingPage.visitor_login');
    }
    public function guideLogin()
    {
        return view('LandingPage.guide_login');
    }


    public function login_post(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $guide = GuideInfo::where('username', $request->username)->first();
        $hiker = Auth::guard('hiker')->user();

    //   if (Auth::attempt($credentials)) {
    //     return redirect()->intended('dashview');
    // } else {
    //     return back()->with('message', 'Your Username and Password were Incorrect!');
    // }

    if ($guide && $guide->status === 'Rejected') {
        return redirect()->route('login')->with('error', 'Your application has been rejected!');
    }

    if (Auth::guard('admin')->attempt($credentials)) {
        return redirect()->intended('dashview'); // Admin dashboard
    }

    // Attempt to login as a hiker
    if (Auth::guard('hiker')->attempt($credentials)) {
        // session(['hiker_id' => $hiker->hiker_id]);
        return redirect()->intended('home'); // Hiker dashboard
    }

    // Attempt to login as a tour guide
    if (Auth::guard('guide')->attempt($credentials)) {
        session(['guide_id' => $guide->guide_id]);
        return redirect()->intended('guideprofile'); // Hiker dashboard
    }

    // If authentication fails
    return redirect()->route('login')->with('error', 'Login Failed!'); 
}


    //REGISTRATION
    public function register()
    {
        return view('LandingPage.registration');
    }

    // Handle the registration form submission
    public function register_post(Request $request)
{
    // Validate the form input

    $request->validate([
        'org_name' => 'required|string|max:255|unique:organization',
        'logo' => 'image|mimes:jpeg,png,jpg,gif,svg',
        'address' => 'required|string',
        'email' => 'required|email|unique:admin',
        'username' => 'required|string|max:255',
        'password' => 'required|string|confirmed',

    ]);
    //handling the logo

    if ($request->hasFile('logo')) {
        $logo = $request->file('logo'); 
    $logoName = time() . '.' . $logo->getClientOriginalExtension();
    $logo->move(public_path('uploads/logo'), $logoName);
    } 

    // Create a new organization
    $organization = new Organization();
    $organization->org_name = $request->org_name;
    $organization->logo = $request->logo;
    $organization->address = $request->address;
    $organization->save();

    // Create a new admin
    $admin = new Admin();
    $admin->email = $request->email;
    $admin->username = $request->username;
    $admin->password = Hash::make($request->password); // Hash the password using bcrypt
    $admin->org_id = $organization->org_id; // Associate the admin with the organization
    $admin->save();


    // Redirect to a success page or login
    return back()->with('message', 'Your registration was successful!');
}

 function visitorreg_post(Request $request)
    {
         $request->validate([
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'email' => 'required|string|email|max:200|unique:hiker_info',
            'age' => 'required|integer',
            'contact_num' => 'required|string|regex:/^[0-9]+$/',  // Ensure it accepts only numeric input
            'username' => 'required|string|unique:hiker_info',
            'password' => 'required|string|confirmed',
        ]);

            HikerInfo::create([
                'last_name' => $request->last_name,
                'first_name' => $request->first_name,
                'email' => $request->email,
                'age' => $request->age,
                'contact_num' => $request->contact_num,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                // 'org_id' => $organization->org_id,
            ]);

            return back()->with('message', 'Your registration was successful!');

    }


    public function guidereg_post(Request $request)
    {
        // Validate the form input
    
        $request->validate([
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'address' => 'required|string',
            'email' => 'string|email|max:200|unique:guide_info',
            'contact_num' => 'required|string|regex:/^[0-9]+$/',  // Ensure it accepts only numeric input
            'proof' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'username' => 'required|string|unique:guide_info',
            'password' => 'required|string|confirmed',
    
        ]);
    
        //Proof Handling
        // if ($request->hasFile('proof')) {
        //     $proof = $request->file('proof');
        //     $proofName = time() . '.' . $proof->getClientOriginalExtension();
        //     $proof->move(public_path('uploads/proofs'), $proofName);
        if ($request->hasFile('proof')) {
            $file = $request->file('proof');
            $path = $file->store('proofs', 'public');
        } else {
            // Handle the case where the file is not present, although it's required
            return back()->withErrors(['proof' => 'Proof is required']);
        }
    
        // guide registration
        GuideInfo::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'address' => $request->address,
            'email' => $request->email,
            'contact_num' => $request->contact_num,
            'proof' => $path, // Save the name of the uploaded file
            'status' => 'Pending', // Set status to 'pending'
            'username' => $request->username,
            'password' => Hash::make($request->password),
            // 'org_id' => org_id
        ]);
        // Redirect to a success page or login
        return back()->with('message', 'Please wait for Admin Confirmation.');
    }
public function dashboardview()
{
    return view('LandingPage.dashboard');
}

public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/login')->with('status', 'Successfully logged out!');
    }
}
