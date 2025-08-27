<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage; 
use Throwable;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.pages.manage-user', compact('users'));
    }

    public function create()
    {
        return view('admin.pages.create-user');
    }

     public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'age' => 'required|numeric|min:18|max:100',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:user,admin',
                'address' => 'required|string|max:255',
                'phone' => 'nullable|string|max:15',
                'driving_license' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            ]);

            if ($validator->fails()) {
                flash()->warning('Please check your form and try again.');
                return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator->errors());
            }

            // Handle driving license upload
            $licensePath = null;
            if ($request->hasFile('driving_license')) {
                $file = $request->file('driving_license');
                $fileName = time() . '_admin_' . $file->getClientOriginalName();
                $licensePath = $file->storeAs('driver_licenses', $fileName, 'public');
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'age' => $request->age,
                'phone' => $request->phone,                    
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'address' => $request->address,
                'driver_license' => $licensePath,              
            ]);

            try {
                Mail::to($request->email)->send(new WelcomeEmail([
                    'name' => $request->name,
                    'email' => $request->email,
                    'created_by' => 'admin',
                    'admin_name' => auth()->user()->name ?? 'Administrator',
                ]));
                Log::info('Welcome email sent successfully to: ' . $request->email);
            } catch (Throwable $th) {
                Log::debug('Error while sending email: ' . $th->getMessage());
            }

            flash()->success('Operation completed successfully.');
            return redirect()->route('admin.users.index');
        } catch (Throwable $th) {
            flash()->error('Operation failed.');
            return redirect()->route('admin.users.index');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            flash()->error('User not found.');
            return redirect()->route('admin.users.index');
        }
        
        return view('admin.pages.edit-user', compact('user'));
    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required|numeric|min:18|max:100',
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:user,admin', 
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'driving_license' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            flash()->warning('Please check your form and try again.');
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors($validator->errors());
        }

        $user = User::find($id);
        
        if (!$user) {
            flash()->error('User not found.');
            return redirect()->route('admin.users.index');
        }

        $licensePath = $user->driver_license; 
        if ($request->hasFile('driving_license')) {
            if ($user->driver_license && \Storage::disk('public')->exists($user->driver_license)) {
                \Storage::disk('public')->delete($user->driver_license);
            }
            
            $file = $request->file('driving_license');
            $fileName = time() . '_admin_' . $file->getClientOriginalName();
            $licensePath = $file->storeAs('driver_licenses', $fileName, 'public');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'phone' => $request->phone,  
            'address' => $request->address,
            'role' => $request->role,
            'driver_license' => $licensePath,
        ]);

        flash()->success('User updated successfully.');
        return redirect()->route('admin.users.index');
    }

    public function delete($id)
    {
        $user = User::find($id);
        
        if (!$user) {
            flash()->error('User not found.');
            return redirect()->route('admin.users.index');
        }
        
        if ($user->driver_license && \Storage::disk('public')->exists($user->driver_license)) {
        \Storage::disk('public')->delete($user->driver_license);
    }
        $user->delete();
        return redirect()->route('admin.users.index');
    }

}