<?php

declare(strict_types=1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class AboutPage extends Component
{
    /** @var array<int, array{role: string, company: string, period: string, description: string}> */
    public array $experiences = [
        [
            'role' => 'PHP Developer',
            'company' => 'Self-employed',
            'period' => 'May 2023 – Present',
            'description' => 'Building custom web applications and consulting on PHP/Laravel projects.',
        ],
        [
            'role' => 'PHP Lead Developer',
            'company' => 'ECOMAIL.CZ',
            'period' => 'Jan 2018 – May 2023',
            'description' => 'Building and maintaining the #1 email marketing platform in Czech Republic and Slovakia. Participating in tech conferences like Laravel Live Denmark and Web Summit.',
        ],
        [
            'role' => 'Senior PHP Developer',
            'company' => 'Slevomat',
            'period' => 'Dec 2016 – Dec 2017',
            'description' => 'Building web services and backend systems for one of the largest Czech e-commerce platforms.',
        ],
        [
            'role' => 'Senior PHP Developer',
            'company' => 'Hanaboso s.r.o.',
            'period' => 'Apr 2016 – Dec 2016',
            'description' => 'Designing and implementing backend modules, code refactoring and application optimization.',
        ],
        [
            'role' => 'Backend Leader Developer',
            'company' => 'el nino parfum, s.r.o.',
            'period' => 'Mar 2015 – Mar 2016',
            'description' => 'Development and maintenance of backend application for customer data management.',
        ],
        [
            'role' => 'PHP Developer',
            'company' => 'eBRÁNA',
            'period' => 'Sep 2012 – Mar 2015',
            'description' => 'Developing information systems and web service tools for end customers.',
        ],
        [
            'role' => 'PHP Developer',
            'company' => 'MALL.cz',
            'period' => 'Dec 2011 – Aug 2012',
            'description' => 'Programming frontend shop modules, code refactoring and backend scripts.',
        ],
        [
            'role' => 'PHP Developer',
            'company' => 'Memos Software',
            'period' => 'Mar 2011 – Nov 2011',
            'description' => 'Working on WordPress and PrestaShop projects.',
        ],
        [
            'role' => 'PHP Developer',
            'company' => 'Cis.cz',
            'period' => 'Aug 2008 – Feb 2011',
            'description' => 'Creating web presentations, implementing e-shop modules, SEO, CSS, JavaScript.',
        ],
    ];

    /** @var array<int, string> */
    public array $focus = [
        'Laravel & PHP development for scalable web applications',
        'Clean code, SOLID principles and code quality',
        'Backend architecture and API development',
        'Automated testing and continuous integration',
        'Performance optimization and refactoring',
    ];

    public function render(): View
    {
        return view('livewire.guest.about-page');
    }
}
