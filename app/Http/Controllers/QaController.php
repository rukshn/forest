<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PostModel;
use App\Models\QaTestModel;
use App\Models\NotificationsModel;
use Illuminate\Support\Facades\Validator;
use Auth;
class QaController extends Controller

{
    public function request_review(Request $request) {
        $rules = [
            'post_id' => 'numeric|required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('message', 'Error setting review');
        } else {
            $find_task = QaTestModel::where('post_id', $request->post_id)->first();

            if (isset($find_task)) {
                return redirect()->back()->with('message', 'This post is already requested for a review');
            }

            $new_test = new QaTestModel();
            $new_test->post_id = $request->post_id;
            $new_test->testing_state = 3;
            $new_test->save();

            return redirect()->back()->with('message', 'Review requested');
        }
    }

    public function get_post_for_review(Request $request) {
        $get_task = DB::table('qatests')->where('post_id', $request->id)
            ->leftJoin('users', 'qatests.assigned_user', '=', 'users.id')
            ->select('qatests.id as test_id', 'users.name as reviewer')->first();


        if (isset($get_task)) {
            $get_post = DB::table('posts')->where('posts.id', $request->id)
            ->leftJoin('qatests', 'posts.id', '=', 'qatests.post_id')
            ->leftJoin('testingstates', 'qatests.testing_state', '=', 'testingstates.id')
            ->select(
                'posts.id as post_id',
                'posts.title as post_title',
                'posts.post as post_content',
                'testingstates.status_name as testing_state_name',
                'testingstates.color as testing_state_color'
            )->first();

            $get_assigns = DB::table('asigns')->where('asigns.post_id', $request->id)
            ->join('users', 'asigns.user_id', '=', 'users.id')
            ->select('users.name as user_name', 'users.id as user_id')->get();

            $get_users = DB::table('users')->select('users.name as name', 'users.id as user_id')->get();

            return view('review', [
                'post' => $get_post,
                'assigned_users' => $get_assigns,
                'users' => $get_users,
                'task_details' => $get_task
            ]);

        } else {
            return abort(404);
        }
    }


    public function assign_user(Request $request) {
        $rules = [
            'post_id' => 'numeric|required',
            'user_id' => 'numeric|required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('message', 'Failed to assign a reviewer');
        } else {
            $find_task = QaTestModel::where('post_id', $request->post_id)->first();
            if ($find_task !== null ) {

                $get_post = DB::table('posts')->where('posts.id', $request->post_id)
                    ->select('posts.created_by')
                    ->first();

                if ($get_post->created_by == $request->user_id) {
                    return redirect()->back()->with('message', 'You cannot assign yourself as a reviewer');
                }

                $find_task->assigned_user = $request->user_id;
                $find_task->save();
                return redirect()->back()->with('message', 'Reviewer assigned');
            } else {
                return redirect()->back()->with('message', 'Task not under review');
            }
        }
    }

    public function complete_review(Request $request) {
        $rules = [
            'test_id' => 'numeric|required',
            'status' => 'numeric|required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('message', 'Error, please try again');
        } else {
            $find_task = QaTestModel::where('id', $request->test_id)->first();

            if (isset($find_task)) {

                if ($find_task->assigned_user != Auth()->user()->id) {
                    return redirect()->back()->with('message', 'You are not allowed to review this task');
                } else {

                    $find_task->testing_state = $request->status;
                    $find_task->save();

                    $get_post = DB::table('posts')->where('posts.id', $find_task->post_id)
                        ->select('posts.created_by', 'posts.id')->first();

                    $notification = new NotificationsModel();
                    $notification->to_user_id = $get_post->created_by;
                    $notification->from_user_id = Auth()->user()->id;
                    $notification->post_id = $get_post->id;
                    $notification->notification_type = 'task';

                    if ($request->status == 1) {
                        $notification->message = "Your task passed the review";
                    } else if ($request->status == 2) {
                        $notification->message = "Your task failed, please check the comments";
                    }
                    $notification->save();

                    return redirect()->back()->with('message', 'Review completed');
                }
            } else {
                return redirect()->back()->with('message', 'Task not under active review');
            }
        }
    }
}