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
        public $announcementId;
    /**
     *  @var boolean;
     */
        public $hasAnnouncement;

    public function __construct($hasAnnouncement, $title, $announcementId)
    {
        $this->hasAnnouncement = $hasAnnouncement;
        $this->title = $title;
        $this->announcementId = $announcementId;
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
