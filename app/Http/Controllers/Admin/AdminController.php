<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (session('admin_logged_in')) {
            return redirect()->route('admin.posts.index');
        }

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        if ($request->password !== config('app.admin_password')) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        session(['admin_logged_in' => true]);

        return redirect()->route('admin.posts.index');
    }

    public function logout()
    {
        session()->forget('admin_logged_in');

        return redirect()->route('admin.login');
    }
}
