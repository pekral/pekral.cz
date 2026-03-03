<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SkillsPage extends Component
{

    public const array CATEGORY_ORDER = ['languages', 'frameworks', 'tools', 'practices'];

    /**
     * @var array<string, array<int, array{name: string, logo?: string, icon?: string}>>
     */
    public array $skills = [
        'frameworks' => [
            ['name' => 'Laravel', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg'],
            ['name' => 'Symfony', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/symfony/symfony-original.svg'],
            ['name' => 'Vue.js', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg'],
            ['name' => 'Tailwind CSS', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg'],
        ],
        'languages' => [
            ['name' => 'PHP', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg'],
            ['name' => 'JavaScript', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg'],
            ['name' => 'SQL', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/azuresqldatabase/azuresqldatabase-original.svg'],
            ['name' => 'HTML', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg'],
            ['name' => 'CSS', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/css3/css3-original.svg'],
        ],
        'practices' => [
            ['name' => 'Clean Code', 'icon' => '✨'],
            ['name' => 'SOLID', 'icon' => '🧱'],
            ['name' => 'DDD', 'icon' => '🏗️'],
            ['name' => 'TDD', 'icon' => '🧪'],
            ['name' => 'CI/CD', 'icon' => '🔄'],
        ],
        'tools' => [
            ['name' => 'Git', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/git/git-original.svg'],
            ['name' => 'Docker', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/docker/docker-original.svg'],
            ['name' => 'AWS', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/amazonwebservices/amazonwebservices-original-wordmark.svg'],
            ['name' => 'DigitalOcean', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/digitalocean/digitalocean-original.svg'],
            ['name' => 'Laravel Forge', 'icon' => '🔧'],
            ['name' => 'Redis', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/redis/redis-original.svg'],
            ['name' => 'MySQL', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg'],
            ['name' => 'PostgreSQL', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/postgresql/postgresql-original.svg'],
            ['name' => 'Rector', 'icon' => '🤖'],
            ['name' => 'PHPUnit', 'icon' => '🧪'],
            ['name' => 'PHPStan', 'icon' => '🔍'],
            ['name' => 'Pint', 'icon' => '🎨'],
        ],
    ];

    /**
     * @return array<string, array<int, array{name: string, logo?: string, icon?: string}>>
     */
    public function getSkillsByCategory(): array
    {
        $ordered = [];

        foreach (self::CATEGORY_ORDER as $key) {
            if (isset($this->skills[$key])) {
                $ordered[$key] = $this->skills[$key];
            }
        }

        return $ordered;
    }

    public function render(): View
    {
        return view('livewire.guest.skills-page');
    }

}
