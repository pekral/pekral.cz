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

    public string $bio = "I'm Petr, Senior PHP Developer with 20+ years of experience. I've worked on large-scale e-commerce platforms, email marketing systems, and custom web applications. Currently self-employed, specializing in Laravel, API development, and scalable backend solutions.";

    public string $profileImage = '/assets/profile-photo.jpg';

    public function render(): View
    {
        return view('livewire.guest.hero-section');
    }
}
