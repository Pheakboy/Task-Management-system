<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return view('admin.dashboard');
        }
        
        return view('dashboard');
    }

    /**
     * Display the admin dashboard.
     */
    public function admin(): View
    {
        return view('admin.dashboard');
    }
}
