<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\AnnouncementModel;

class announcementView extends Component
{
    /**
     * Create a new component instance.
     *  @var string
     */
        public $title;
    /**
    *   @var string;
    */
        public $announcement;
    /**
     *  @var integer;
     */
        public $announcement_id;
    /**
     *  @var boolean;
     */
        public $has_announcement;

    public function __construct()
    {
        $get_announcement = AnnouncementModel::where('is_pinned', true)->first();
        $this->has_announcement = false;
        if (isset($get_announcement)) {
            $this->has_announcement = true;
            $this->title = $get_announcement->title;
            $this->announcement = $get_announcement->announcement;
            $this->announcement_id = $get_announcement->id;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.announcement-view');
    }
}
