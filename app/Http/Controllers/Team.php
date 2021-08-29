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
        $sql = 'SELECT SUM(ps.status_id = 1) AS asigned_tasks, SUM(ps.status_id = 2) AS in_progress_tasks, SUM(ps.status_id = 3) AS completed_tasks, COUNT(a.user_id = u.id) AS total_tasks, u.name, u.id as user_id FROM users u LEFT JOIN asigns a ON a.user_id = u.id LEFT JOIN post_status ps ON a.post_id = ps.post_id GROUP BY u.id,u.name ORDER BY completed_tasks DESC';
        $team = DB::select($sql);
        return view('team', ['team' => $team]);
    }
}
