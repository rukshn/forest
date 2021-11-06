<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\DB;

class LeftSidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $categories;
    public function __construct()
    {
        //
        $this->categories = DB::table('categories')->where('retired', false)->select('name', 'id', 'color')->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.leftsidebar');
    }
}
