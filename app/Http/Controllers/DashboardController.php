<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    function getUserTasks($user_id){
        return DB::table('tasks')
        ->where('user_id', $user_id)
        ->get();
    }

    public function showDashboard(Request $request)
    {
        $user_id = Auth::user()->id;
        $tasks = $this->getUserTasks($user_id);

        return view('dashboard', ["tasks" => $tasks]);
    }
}
