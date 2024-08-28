<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\HikerInfo;
use App\Models\GuideInfo;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class NotificationControl extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            // Check if the email exists in the User (admin), HikerInfo (hiker), or GuideInfo (guide) table
            $user = User::where('email', $request->email)->first();
            $hiker = HikerInfo::where('email', $request->email)->first();
            $guide = GuideInfo::where('email', $request->email)->first();

            if (!$user && !$hiker && !$guide) {
                return response()->json(['error' => 'Email does not exist.'], 400);
            }

            // Generate a random 4-digit verification code
            $verificationCode = rand(1000, 9999);

            // Save the verification code, email, and account type in the session
            Session::put('verification_code', $verificationCode);
            Session::put('email', $request->email);

            // Identify the account type
            if ($user) {
                Session::put('account_type', 'admin');
            } elseif ($hiker) {
                Session::put('account_type', 'hiker');
            } elseif ($guide) {
                Session::put('account_type', 'guide');
            }

            // Send the verification code to the user's email
            Mail::raw("Your verification code is: $verificationCode", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Verification Code');
            });

            return response()->json(['success' => 'Verification code sent successfully.']);
        } catch (\Exception $e) {
            Log::error('Error sending verification code: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while sending the verification code. Please try again later.'], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|numeric',
            ]);

            // Retrieve the code, email, and account type from the session
            $sessionCode = Session::get('verification_code');
            $email = Session::get('email');
            $accountType = Session::get('account_type');

            Log::info('Session Data in verifyCode:', Session::all());

            // Ensure email and account type are present in the session
            if (!$email || !$accountType) {
                Log::error('Email or account type not found in session.');
                return response()->json(['error' => 'Session expired. Please try again.'], 400);
            }

            // Initialize user, hiker, and guide variables
            $user = null;
            $hiker = null;
            $guide = null;

            // Retrieve the user, hiker, or guide based on the email and account type
            if ($accountType == 'admin') {
                $user = User::where('email', $email)->first();
                if ($user) {
                    Session::put('user_id_to_reset', $user->admin_id); // Use admin_id
                    Log::info('User ID stored in session: ' . $user->admin_id);
                }
            } elseif ($accountType == 'hiker') {
                $hiker = HikerInfo::where('email', $email)->first();
                if ($hiker) {
                    Session::put('user_id_to_reset', $hiker->hiker_id); // Use hiker_id
                    Log::info('Hiker ID stored in session: ' . $hiker->hiker_id);
                }
            } elseif ($accountType == 'guide') {
                $guide = GuideInfo::where('email', $email)->first();
                if ($guide) {
                    Session::put('user_id_to_reset', $guide->guide_id); // Use guide_id
                    Log::info('Guide ID stored in session: ' . $guide->guide_id);
                }
            }

            // Check if none were found
            if (!$user && !$hiker && !$guide) {
                Log::error('User, Hiker, or Guide not found with email: ' . $email);
                return response()->json(['error' => 'User not found.'], 404);
            }

            // Compare the session code with the provided code
            if ($sessionCode && $request->code == $sessionCode) {
                return response()->json(['success' => 'Verification code is correct.']);
            } else {
                Log::error('Incorrect verification code provided.');
                return response()->json(['error' => 'Incorrect verification code.'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error in verifyCode method: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while verifying the code. Please try again later.'], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'new_password' => 'required|min:8|confirmed',
            ]);

            // Retrieve the user ID and account type from the session
            $userId = Session::get('user_id_to_reset');
            $accountType = Session::get('account_type');

            if (!$userId || !$accountType) {
                return response()->json(['error' => 'Session expired or invalid. Please start the process again.'], 400);
            }

            // Initialize user, hiker, and guide variables
            $user = null;
            $hiker = null;
            $guide = null;

            // Find the user, hiker, or guide based on the account type
            if ($accountType == 'admin') {
                $user = User::find($userId);
                if ($user) {
                    $user->password = bcrypt($request->new_password);
                    $user->save();
                }
            } elseif ($accountType == 'hiker') {
                $hiker = HikerInfo::find($userId);
                if ($hiker) {
                    $hiker->password = bcrypt($request->new_password);
                    $hiker->save();
                }
            } elseif ($accountType == 'guide') {
                $guide = GuideInfo::find($userId);
                if ($guide) {
                    $guide->password = bcrypt($request->new_password);
                    $guide->save();
                }
            }

            // Check if none were found
            if (!$user && !$hiker && !$guide) {
                return response()->json(['error' => 'User not found.'], 404);
            }

            // Clear session data
            Session::forget(['verification_code', 'user_id_to_reset', 'email', 'account_type']);

            return response()->json(['success' => 'Password updated successfully.']);
        } catch (\Exception $e) {
            Log::error('Error resetting password: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while resetting the password. Please try again later.'], 500);
        }
    }
}
