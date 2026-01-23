<?php

declare(strict_types=1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SkillsSection extends Component
{
    /**
     * @var array<string, array<int, array{name: string, logo?: string, icon?: string}>>
     */
    public array $skills = [
        'frameworks' => [
            ['name' => 'Laravel', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg'],
            ['name' => 'Symfony', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/symfony/symfony-original.svg'],
            ['name' => 'React', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg'],
            ['name' => 'Vue.js', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/vuejs/vuejs-original.svg'],
            ['name' => 'Tailwind CSS', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/tailwindcss/tailwindcss-original.svg'],
        ],
        'languages' => [
            ['name' => 'PHP', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg'],
            ['name' => 'JavaScript', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg'],
            ['name' => 'TypeScript', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/typescript/typescript-original.svg'],
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
            ['name' => 'Rector', 'icon' => '🤖'],
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
            ['name' => 'macOS', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apple/apple-original.svg'],
            ['name' => 'PHPUnit', 'logo' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/phpunit/phpunit-original.svg'],
            ['name' => 'PHPStan', 'icon' => '🔍'],
            ['name' => 'Pint', 'icon' => '🎨'],
        ],
    ];

    public function render(): View
    {
        return view('livewire.guest.skills-section');
    }
}
