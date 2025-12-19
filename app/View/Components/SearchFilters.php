<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchFilters extends Component
{
    public $action;
    public $placeholder;
    public $filters;

    public function __construct(
        $action,
        $placeholder = 'Buscar...',
        $filters = []
    ) {
        $this->action = $action;
        $this->placeholder = $placeholder;
        $this->filters = $filters;
    }

    public function render()
    {
        return view('components.search-filters');
    }
}
