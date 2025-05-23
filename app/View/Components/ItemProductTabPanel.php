<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ItemProductTabPanel extends Component
{
    public $categories;
    public $token;
    /**
     * Create a new component instance.
     */
    public function __construct($categories, $token)
    {
        $this->categories = $categories;
        $this->token = $token;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.item-product-tab-panel');
    }
}
