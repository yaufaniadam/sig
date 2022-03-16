<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Inbox extends Component
{
    public function render()
    {
        return view('livewire.inbox')
        ->layout('components.layoutfront');
    }
}
