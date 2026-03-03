<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class AboutPage extends Component
{

    /**
     * @return array<int, array{role: string, company: string, period: string, description: string}>
     */
    public function getExperiences(): array
    {
        $experiences = [];

        for ($i = 0; $i <= 8; $i++) {
            $experiences[] = [
                'company' => __('guest.about.experiences.' . $i . '.company'),
                'description' => __('guest.about.experiences.' . $i . '.description'),
                'period' => __('guest.about.experiences.' . $i . '.period'),
                'role' => __('guest.about.experiences.' . $i . '.role'),
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
