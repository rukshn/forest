<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\CommentModel;

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
