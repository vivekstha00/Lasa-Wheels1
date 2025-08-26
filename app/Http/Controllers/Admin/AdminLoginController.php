<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon\Carbon;

class AdminLoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.pages.login');
    }

    public function check(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:6',
            ]);

            if ($validator->fails()) {
                toastr()->warning('Validation failed. Please check your input.');
                return redirect()->back()
                ->withInput($request->input())
                ->withErrors($validator->errors());
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                toastr()->success('Login successful!');
                return redirect()->route('admin.dashboard');
            } else {
                toastr()->error('Invalid credentials. Please try again.');
                return redirect()->back()->withInput($request->input());
            }
        } catch (Throwable $e) {
            toastr()->error($e->getMessage());
            return redirect()->back()->withInput($request->input());
        }
    }

    public function verification($token)
    {
        $tokenExists = User::where('verification_token', $token)->first();
        if (!$tokenExists) {
            $tokenExists->update([
                'email_verified_at' => Carbon::now(),
                'verification_token' => null,
            ]);
            toastr()->success('User verified successfully.');
        } else {
            toastr()->error('Invalid verification token.');
            return redirect()->route('admin.login');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        toastr()->success('You have been logged out successfully.');
        return redirect()->route('admin.login');
    }
}

