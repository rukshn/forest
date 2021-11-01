<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class composerComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $get_milestones = DB::table('post_meta')->where('category_id', 3)->where('posts.is_archived', false)
        ->join('posts', 'posts.id', '=', 'post_meta.post_id')
        ->select('posts.id as milestone_id', 'posts.title as milestone')
        ->get();

        return view('components.composer-component', ['milestones' => $get_milestones]);
    }
}
