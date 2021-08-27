<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\CommentModel;
use App\Models\NotificationsModel;
use App\Models\PostModel;

class Comments extends Controller
{
    //
    public function create_comment(Request $request) {
        $rules = [
            'comment' => 'required',
            'post_id' => 'required|numeric'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error posting comment');
        } else {
            $user_id = Auth::id();

            $post = PostModel::find($request->post_id);

            if ($user_id !== $post->created_by) {
                $new_notification = new NotificationsModel();
                $new_notification->from_user_id = $user_id;
                $new_notification->to_user_id = $post->created_by;
                $new_notification->message = auth()->user()->name . ' commented on your post';
                $new_notification->notification_type = 'comment';
                $new_notification->post_id = $request->post_id;
                $new_notification->save();
            }

            $get_comments = CommentModel::where('post_id', $request->post_id)->get();

            foreach ($get_comments as $comment) {
                if ($comment->created_by !== $user_id && $comment->created_by !== $post->created_by) {
                    $new_notification = new NotificationsModel();
                    $new_notification->from_user_id = $user_id;
                    $new_notification->to_user_id = $comment->created_by;
                    $new_notification->message = auth()->user()->name . ' commented on a post you are following';
                    $new_notification->notification_type = 'comment';
                    $new_notification->post_id = $request->post_id;
                    $new_notification->save();
                }
            }

            $new_comment = new CommentModel;
            $new_comment->post_id = $request->post_id;
            $new_comment->comment = $request->comment;
            $new_comment->created_by = $user_id;
            $new_comment->save();

            return redirect()->back()->with('message', 'Comment posted');
        }
    }

    public function edit_comment(Request $request) {

    }

    public function delete_comment(Request $request) {

    }
}
