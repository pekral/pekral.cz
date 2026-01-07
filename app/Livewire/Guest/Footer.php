<?php

declare(strict_types=1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Footer extends Component
{
    public function render(): View
    {
        return view('livewire.guest.footer');
    }
}
