<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
Use App\Models\User;

class Team extends Controller
{
    //

    public function index(Request $request) {
        $team = User::select('users.name',
                DB::raw('(select count(*) from asigns where asigns.user_id = users.id) as task_count'),
                DB::raw('(select count(*) from post_status where post_status.status_id = 2 and post_status.post_id = posts.id)
                        as assigned_tasks'),
                DB::raw('(select count(*) from post_status where post_status.status_id = 3 and post_status.post_id = posts.id)
                        as completed_tasks')
                )
                ->leftJoin('asigns', 'users.id', '=', 'asigns.user_id')
                ->join('posts', 'posts.id', '=', 'asigns.post_id')
                ->join('post_status', 'post_status.post_id', '=', 'posts.id')
                ->orderBy('completed_tasks', 'desc')
                ->distinct()
                ->get();

        // return json_encode($team);

        return view('team', ['team' => $team]);
    }
}
