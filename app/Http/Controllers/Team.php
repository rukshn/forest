<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use App\Models\User;

class Team extends Controller
{
    //

    public function index(Request $request) {
        $team = User::all();
        return view('team', ['team' => $team]);
    }
}
