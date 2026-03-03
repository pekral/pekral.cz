<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class HeroSection extends Component
{

    public string $name;

    public string $role;

    public string $location;

    public string $bio;

    public string $profileImage = '/assets/profile-photo.jpg';

    public function mount(): void
    {
        $this->name = __('guest.hero.name');
        $this->role = __('guest.hero.role');
        $this->location = __('guest.hero.location');
        $this->bio = __('guest.hero.bio');
    }

    public function render(): View
    {
        return view('livewire.guest.hero-section');
    }

}
