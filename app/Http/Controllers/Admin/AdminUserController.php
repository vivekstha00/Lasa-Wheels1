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
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:user,admin',
                'address' => 'required|string|max:255',
            ]);

            if ($validator->fails()) {
                flash()->warning('Please check your form and try again.');
                return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator->errors());
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Hash the password
                'role' => $request->role,
                'address' => $request->address,
            ]);

            try {
                Mail::to($request->email)->send(new WelcomeEmail([
                    'name' => $request->name,
                ]));
            } catch (Throwable $th) {
                Log::debug('Error while sending email.');
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
            'email' => 'required|email|unique:users,email,'.$id,
            'role' => 'required|in:user,admin', 
            'address' => 'required|string|max:255',
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

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'role' => $request->role,
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
        
        $user->delete();
        return redirect()->route('admin.users.index');
    }

}