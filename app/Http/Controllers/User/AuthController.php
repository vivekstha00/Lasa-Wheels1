<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $user = User::where('email', $request->email)->first();
            
            if (!$user) {
                return response()->json(['error' => 'Email not found in our system'], 404);
            }

            // Generate 4-digit OTP
            $otp = rand(1000, 9999);
            
            // Set OTP expiration (10 minutes from now)
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(10)
            ]);

            // Send OTP email
            Mail::to($user->email)->send(new OTPMail($otp));
            
            Log::info('Password reset OTP sent to: ' . $user->email);

            return response()->json([
                'message' => 'OTP sent to your email successfully',
                'expires_in' => '10 minutes'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Failed to send OTP: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to send OTP. Please try again.'], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:4',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email not found'], 404);
        }

        if (!$user->otp) {
            return response()->json(['error' => 'No OTP found. Please request a new one.'], 400);
        }

        // Check if OTP is expired
        if ($user->otp_expires_at && Carbon::now()->gt($user->otp_expires_at)) {
            $user->update(['otp' => null, 'otp_expires_at' => null]);
            return response()->json(['error' => 'OTP has expired. Please request a new one.'], 400);
        }

        if ($user->otp != $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 400);
        }

        return response()->json(['message' => 'OTP verified successfully'], 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:4',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['error' => 'Email not found'], 404);
            }

            if (!$user->otp) {
                return response()->json(['error' => 'No OTP found. Please request a new one.'], 400);
            }

            // Check if OTP is expired
            if ($user->otp_expires_at && Carbon::now()->gt($user->otp_expires_at)) {
                $user->update(['otp' => null, 'otp_expires_at' => null]);
                return response()->json(['error' => 'OTP has expired. Please request a new one.'], 400);
            }

            if ($user->otp != $request->otp) {
                return response()->json(['error' => 'Invalid OTP'], 400);
            }

            // Reset password and clear OTP
            $user->update([
                'password' => bcrypt($request->password),
                'otp' => null,
                'otp_expires_at' => null
            ]);

            Log::info('Password reset successful for: ' . $user->email);

            return response()->json(['message' => 'Password reset successful'], 200);

        } catch (\Exception $e) {
            Log::error('Password reset failed: ' . $e->getMessage());
            return response()->json(['error' => 'Password reset failed. Please try again.'], 500);
        }
    }
}
