<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use App\Models\User;
Use App\Models\AsignModel;

class Team extends Controller
{
    //

    public function index(Request $request) {
       $team = DB::table('users')
            ->leftJoin('asigns', 'asigns.user_id', '=', 'users.id')
            ->leftJoin('post_status', 'asigns.id', '=', 'post_status.post_id')
            ->select('users.name as name', 'users.id as user_id',
                    DB::raw('SUM(post_status.status_id = 2) as in_progress_tasks'),
                    DB::raw('SUM(post_status.status_id = 3) as completed_tasks'),
                    DB::raw('SUM(post_status.status_id = 1) as asigned_tasks'),
                    DB::raw('(select count(*) from asigns where asigns.user_id = users.id) as total_tasks'))
            ->groupBy('users.id', 'users.name')
            ->orderBy('completed_tasks', 'DESC')
            ->get();

        return view('team', ['team' => $team]);
        // return json_encode($team);
    }
}
