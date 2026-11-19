<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class AboutPage extends Component
{

    /**
     * @return array<int, array{role: string, company: string, period: string, description: string, about: string, location: string, website: string}>
     */
    public function getExperiences(): array
    {
        $experiences = [];

        for ($i = 0; $i <= 8; $i++) {
            $experiences[] = [
                'about' => __('guest.about.experiences.' . $i . '.about'),
                'company' => __('guest.about.experiences.' . $i . '.company'),
                'description' => __('guest.about.experiences.' . $i . '.description'),
                'location' => __('guest.about.experiences.' . $i . '.location'),
                'period' => __('guest.about.experiences.' . $i . '.period'),
                'role' => __('guest.about.experiences.' . $i . '.role'),
                'website' => __('guest.about.experiences.' . $i . '.website'),
            ];
        }

        return $experiences;
    }

    /**
     * @return array<int, string>
     */
    public function getFocus(): array
    {
        $focus = [];

        for ($i = 0; $i <= 4; $i++) {
            $focus[] = __('guest.about.focus.' . $i);
        }

        return $focus;
    }

    public function render(): View
    {
        return view('livewire.guest.about-page', [
            'experiences' => $this->getExperiences(),
            'focus' => $this->getFocus(),
        ]);
    }

}
