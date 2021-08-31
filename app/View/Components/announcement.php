<?php

namespace App\View\Components;

use Illuminate\View\Component;

class announcement extends Component
{
    /**
     * Create a new component instance.
     *  @var string
     */
        public $title;
    /**
     *  @var integer;
     */
        public $announcement_id;
    /**
     *  @var boolean;
     */
        public $has_announcement;

    public function __construct($hasAnnouncement, $title, $announcementId)
    {
        $this->has_announcement = $hasAnnouncement;
        $this->title = $title;
        $this->announcement_id = $announcementId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.announcement');
    }
}
