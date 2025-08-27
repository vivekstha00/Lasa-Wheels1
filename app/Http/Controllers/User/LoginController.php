<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Log;
use Throwable;

class LoginController extends Controller
{
    public function index()
    {
        return view('user.pages.login');
    }
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Login successful!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function register()
    {
        return view('user.pages.register');
    }
    public function registerStore(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:500',
            'password' => 'required|min:6',
            'driving_license' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            $licensePath = null;
            if ($request->hasFile('driving_license')) {
                $file = $request->file('driving_license');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $licensePath = $file->storeAs('driver_licenses', $fileName, 'public');
                
                // DEBUG: Log the file path to check if it's being saved
                Log::info('License file saved to: ' . $licensePath);
            }
            
            $user = User::create([
                'name' => $request->full_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'password' => Hash::make($request->password),
                'driver_license' => $licensePath,  // CHANGE: Use driver_license (database field name)
                'role' => 'user',
            ]);
            
            // DEBUG: Check if user was created with license
            Log::info('User created with license: ' . $user->driver_license);
            
            try {
                Mail::to($user->email)->send(new WelcomeEmail([
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_by' => 'self_registration'
                ]));
                Log::info('Welcome email sent successfully to: ' . $user->email);
            } catch (Throwable $th) {
                Log::debug('Error while sending email: ' . $th->getMessage());
            }

            auth()->login($user);
            return redirect()->route('home')->with('success', 'Registration successful! You are now logged in.');
            
        } catch (\Exception $e) {
            Log::error('Registration failed: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }
}
