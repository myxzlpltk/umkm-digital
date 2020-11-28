<?php

namespace App\View\Components;

use App\Models\OrderDetail;
use Illuminate\View\Component;

class OrderDetailProduct extends Component
{

    public $detail;
    public $withAction;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(OrderDetail $detail, bool $action = true)
    {
        $this->detail = $detail;
        $this->withAction = $action;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.order-detail-product', [
            'detail' => $this->detail,
            'withAction' => $this->withAction,
        ]);
    }
}
