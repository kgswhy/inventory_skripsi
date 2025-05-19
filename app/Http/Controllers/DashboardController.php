<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Count only staff users (excluding admin)
        $totalStaff = User::where('role', 'staff')->count();
        $activeStaff = User::where('role', 'staff')
                          ->where('status', 'active')
                          ->count();
        
        // You can implement these based on your task management system
        $pendingTasks = 0;
        $completedTasks = 0;
        
        // You can implement this based on your activity logging system
        $recentActivities = collect();
        
        return view('admin.dashboard', compact(
            'totalStaff',
            'activeStaff',
            'pendingTasks',
            'completedTasks',
            'recentActivities'
        ));
    }
} 