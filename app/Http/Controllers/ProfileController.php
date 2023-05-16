<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ProfileController extends Controller
{

    public function showProfile(Request $request)
    {
        $user_id = Auth::user()->id;

        $info = DB::table('users')
        ->where('id', $user_id)
        ->first();

        return view('profile', ["info" => $info]);
    }
}
