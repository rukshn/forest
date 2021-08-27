<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\NotificationsModel;

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

    public function __construct($title) {
        $this->title = " - " . $title;
        $this->notification_count = NotificationsModel::where('to_user_id', auth()->user()->id)
            ->where('has_opened', false)->count();
    }

    public function render()
    {
        return view('layouts.app', ['notification_count' => $this->notification_count]);
    }
}
