<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\PostModel;
use App\Models\PostStatusModel;
use App\Models\AsignModel;

class Kanban extends Controller
{
    //

    public function index(Request $request) {
        return view('kanban');
    }

    public function tasks(Request $request) {
        $tasks = DB::table('post_meta')->where('posts.is_archived', false)->where('category_id', '2')->orWhere('category_id', '1')->where('posts.is_archived', false)
            ->join('posts', 'posts.id', '=', 'post_meta.post_id')
            ->leftJoin('post_status', 'post_status.post_id', '=', 'posts.id')
            ->leftJoin('status_codes', 'post_status.status_id', '=', 'status_codes.id')
            ->leftJoin('categories', 'categories.id', '=', 'post_meta.category_id')
            ->select('posts.title as post_title', 'posts.id as post_id', 'posts.created_at as date',
                    'status_codes.status_name as status_code',
                    'status_codes.id as status_code_id',
                    'status_codes.color as status_color',
                    'post_status.id as post_status_id',
                    'categories.name as category_name', 'categories.color as category_color')
            ->get();

        return $tasks;
    }

    public function beginTask(Request $request) {
        $rules = [
            'post_id' => 'required|numeric',
            'post_status_id' => 'required|numeric'
        ];

        $validate = Validator($request->all(), $rules);

        if ($validate->fails()) {
            return json_encode('invalid requrest');
        } else {
            $find_status = PostStatusModel::find($request->post_status_id);
            if ($find_status->first() !== NULL) {
                $find_status->status_id = 2;
                $find_status->save();
            } else {
                $new_status = new PostStatusModel();
                $new_status->post_id = $request->post_id;
                $new_status->status_id = 2;
            }

            $user_id = Auth::id();

            $find_assign = AsignModel::where('post_id', $request->post_id)->where('user_id', $user_id)->first();

            if (!isset($find_assign)) {
                $new_assign = new AsignModel();
                $new_assign->post_id = $request->post_id;
                $new_assign->user_id = $user_id;
                $new_assign->assigned_by = $user_id;
                $new_assign->save();
            }

            $output = [
                'status' => 200,
                'message' => 'tasks assigned'
            ];
            return json_encode($output);
        }
    }

    public function completeTask(Request $request) {
        $rules = [
            'post_id' => 'required|numeric',
            'post_status_id' => 'required|numeric'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return json_encode("invalid request");
        } else {
            $find_status = PostStatusModel::find($request->post_status_id);
            if ($find_status->first() !== NULL) {
                $find_status->status_id = 3;
                $find_status->save();
            } else {
                $new_status = new PostStatusModel();
                $new_status->post_id = $request->post_id;
                $new_status->status_id = 3;
            }

            $output = [
                'status' => 200,
                'message' => 'task completed'
            ];

            return json_encode($output);
        }

    }
}
