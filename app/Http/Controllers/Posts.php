<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\PostModel;

class Posts extends Controller
{
    //

    public function new_post(Request $request) {
        $rules = [
            'title' => 'required',
            'post' => 'required',
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('message', 'Error creating post');
        } else {
            $user_id = Auth()->id;
            $new_post = new PostModel();
            $new_post->title = $request->title;
            $new_post->content = $request->content;
            $new_post->created_by = $user_id;
            $new_post->save();
            return redirect()->route('post', ['id' => $new_post->id]);
        }
    }

    public function get_post(Request $request) {
        $rules [
            'id' => 'required';
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->route();
        } else {
            $post = PostModel:select('id', $request->id);
            return view('post')->with('post_content', $post);
        }
    }
}
