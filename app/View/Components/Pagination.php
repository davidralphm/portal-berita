<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Pagination extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $currentPage,
        public bool $onFirstPage,
        public bool $onLastPage,
        public string $prevPageUrl,
        public string $nextPageUrl
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.pagination');
    }
}
