<?php

declare(strict_types=1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class HeroSection extends Component
{
    public string $name = 'Petr Král';

    public string $role = 'PHP Developer';

    public string $location = 'Chlumec nad Cidlinou, Czech Republic';

    public string $bio = "I'm a Senior PHP Developer and Laravel programmer with over 20 years of experience building web applications. As a passionate open source contributor, I focus on clean code, backend architecture, and developer tooling. Currently self-employed, I specialize in Laravel development, REST API programming, and scalable PHP solutions.";

    public string $profileImage = '/assets/profile-photo.jpg';

    public function render(): View
    {
        return view('livewire.guest.hero-section');
    }
}
