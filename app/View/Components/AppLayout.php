<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\NotificationsModel;
use App\Models\AnnouncementModel;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */

     /**
      * @var string
      */
      public $title;
      /**
       * @var integer
       */
      public $notification_count;

      /**
       * @var boolean
       */
      public $has_announcement;
    public function __construct($title) {
        $this->title = " - " . $title;
        $this->notification_count = NotificationsModel::where('to_user_id', auth()->user()->id)
            ->where('has_opened', false)->count();

        $announcement = AnnouncementModel::where('is_pinned', true)->first();
        if (isset($announcement)) {
            $this->has_announcement = true;
        } else {
            $this->has_announcement = false;
        }
    }

    public function render()
    {
        return view('layouts.app', [
            'notification_count' => $this->notification_count,
            'announcement' => $this->has_announcement
        ]);
    }
}
