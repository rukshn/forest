<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PostModel;
use App\Models\PostMetaModel;

class Posts extends Controller
{
    //

    public function new_post(Request $request) {
        $rules = [
            'title' => 'required',
            'post' => 'required',
            'category' => 'required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error creating post');
        } else {
            $user_id = Auth::id();
            $new_post = new PostModel();
            $new_post->title = $request->title;
            $new_post->post = $request->post;
            $new_post->created_by = $user_id;
            $new_post->save();

            $post_meta = new PostMetaModel;
            $post_meta->post_id = $new_post->id;
            $post_category = $request->category;

            return redirect()->route('post', ['id' => $new_post->id]);
        }
    }

    public function get_post(Request $request) {

    }

    public function edit_post(Request $request) {

    }

    public function delete_post(Request $request) {

    }
}
