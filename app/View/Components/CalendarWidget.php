<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Collection;

class CalendarWidget extends Component
{

    public Collection|array $events;
    /**
     * Create a new component instance.
     */
    public function __construct(Collection|array $events = [])
    {
        $this->events = $events;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.calendar-widget');
    }
}
