<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        
        // Get todo statistics
        $totalTodos = Todo::where('user_id', $userId)->count();
        $completedTodos = Todo::where('user_id', $userId)
            ->where('is_completed', true)
            ->count();
        $pendingTodos = Todo::where('user_id', $userId)
            ->where('is_completed', false)
            ->count();
        
        // Get recent todos
        $recentTodos = Todo::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get upcoming todos
        $upcomingTodos = Todo::where('user_id', $userId)
            ->where('is_completed', false)
            ->where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalTodos',
            'completedTodos',
            'pendingTodos',
            'recentTodos',
            'upcomingTodos'
        ));
    }
}