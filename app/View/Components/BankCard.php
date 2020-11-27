<?php

namespace App\View\Components;

use App\Models\Bank;
use Illuminate\View\Component;

class BankCard extends Component
{

    public $bank;
    public $number;
    public $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Bank $bank, string $number, string $name){
        $this->bank = $bank;
        $this->number = $number;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.bank-card');
    }
}
