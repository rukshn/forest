<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\AnnouncementModel;

class AnnouncementController extends Controller
{
    //
    public function new_announcement(Request $request) {
        $rules = [
            'announcement' => 'required',
            'title' => 'required',
            'is_pinned' => 'required'
        ];

        $validate = Validator::make($request->all(), $rules);
        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error creating announcement');
        } else {
            $new_announcement = new AnnouncementModel();
            $new_announcement->title = $request->title;
            $new_announcement->announcement = $request->announcement;
            $new_announcement->created_by = auth()->user()->id;
            $new_announcement->is_pinned = $request->is_pinned;

            $find_pinned_announcement = AnnouncementModel::where('is_pinned', true)->first();
            if (isset($find_pinned_announcement)) {
                $find_pinned_announcement->is_pinned = false;
                $find_pinned_announcement->save();
            }

            $new_announcement->save();

            return redirect()->back()->with('message', 'Announcement Created');
        }
    }

    public function get_announcement(Request $request) {
        $announcement = DB::table('announcements')->where('announcements.id', $request->announcement_id)
            ->join('users', 'users.id', '=', 'announcements.created_by')
            ->select('announcements.title as post_title',
                'announcements.announcement as post_content',
                'announcements.created_at',
                'announcements.id as post_id',
                'users.name as user_name')->first();
        if ($announcement === null) {
            return abort(404);
        } else {
            return view('announcement', ['post' => $announcement]);
        }
    }

    public function archive_announcement(Request $request) {
        $rules = [
            'post_id' => 'numeric|required'
        ];

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return redirect()->back()->with('error', 'Error unpinning announcement');
        } else {
            $announcement = AnnouncementModel::find($request->post_id);
            if ($announcement !== null) {
                if ($announcement->is_pinned == true) {
                    $announcement->is_pinned = false;
                    $announcement->save();
                    return redirect()->back()->with('message', 'Announcement unpinned');
                } else {
                    $announcement->is_pinned = true;
                    $announcement->save();
                    return redirect()->back()->with('message', 'Announcement pinned');
                }
            } else {
                return redirect()->back()->with('error', 'Error unpinning announcement');
            }
        }
    }
}
