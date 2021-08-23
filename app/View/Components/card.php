<?php

namespace App\View\Components;

use Illuminate\View\Component;

class card extends Component
{
    /**
     * Create a new component instance.
     *
     *
     */
    /**
     * @var string
    */
    public $title;
    /**
     * @var string
    */
    public $author;
    /**
     * @var string
    */
    public $date;
    /**
     * @var string
    */
    public $category;
    /**
     * @var string
    */
    public $ccolor;
    /**
     * @var string
    */
    public $status;
    /**
     * @var string
    */
    public $scolor;
    /**
     * @var integer;
     */
    public $pid;
    /**
     * @var integer;
     */
    public $comments;

    public function __construct($title, $author, $date, $category, $ccolor, $status, $scolor, $pid, $comments)
    {
        //
        $this->title = $title;
        $this->author = explode(' ', $author)[0];
        $str_date = strtotime($date);
        $this->date = date('d-m-Y', $str_date);
        $this->category = $category;
        $this->ccolor = $ccolor;
        if ($comments == NULL) {
            $this->comments = 0;
        } else {
            $this->comments = $comments;
        }

        $this->pid = $pid;

        if ($status == NULL) {
            $status = '';
        } else {
            $this->status = $status;
        }
        if ($scolor == NULL) {
            $scolor = '';
        } else {
            $this->scolor = $scolor;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card');
    }
}
