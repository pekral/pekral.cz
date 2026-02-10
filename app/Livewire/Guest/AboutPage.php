<?php

declare(strict_types = 1);

namespace App\Livewire\Guest;

use Illuminate\Contracts\View\View;
use Livewire\Component;

final class AboutPage extends Component
{

    /**
     * @var array<int, array{role: string, company: string, period: string, description: string}>
     */
    public array $experiences = [
        [
            'company' => 'Self-employed',
            'description' => 'Building custom web applications and consulting on PHP/Laravel projects.',
            'period' => 'May 2023 – Present',
            'role' => 'PHP Developer',
        ],
        [
            'company' => 'ECOMAIL.CZ',
            'description' => 'Building and maintaining the #1 email marketing platform in Czech Republic and Slovakia. '
                . 'Participating in tech conferences like Laravel Live Denmark and Web Summit.',
            'period' => 'Jan 2018 – May 2023',
            'role' => 'PHP Lead Developer',
        ],
        [
            'company' => 'Slevomat',
            'description' => 'Building web services and backend systems for one of the largest Czech e-commerce platforms.',
            'period' => 'Dec 2016 – Dec 2017',
            'role' => 'Senior PHP Developer',
        ],
        [
            'company' => 'Hanaboso s.r.o.',
            'description' => 'Designing and implementing backend modules, code refactoring and application optimization.',
            'period' => 'Apr 2016 – Dec 2016',
            'role' => 'Senior PHP Developer',
        ],
        [
            'company' => 'el nino parfum, s.r.o.',
            'description' => 'Development and maintenance of backend application for customer data management.',
            'period' => 'Mar 2015 – Mar 2016',
            'role' => 'Backend Leader Developer',
        ],
        [
            'company' => 'eBRÁNA',
            'description' => 'Developing information systems and web service tools for end customers.',
            'period' => 'Sep 2012 – Mar 2015',
            'role' => 'PHP Developer',
        ],
        [
            'company' => 'MALL.cz',
            'description' => 'Programming frontend shop modules, code refactoring and backend scripts.',
            'period' => 'Dec 2011 – Aug 2012',
            'role' => 'PHP Developer',
        ],
        [
            'company' => 'Memos Software',
            'description' => 'Working on WordPress and PrestaShop projects.',
            'period' => 'Mar 2011 – Nov 2011',
            'role' => 'PHP Developer',
        ],
        [
            'company' => 'Cis.cz',
            'description' => 'Creating web presentations, implementing e-shop modules, SEO, CSS, JavaScript.',
            'period' => 'Aug 2008 – Feb 2011',
            'role' => 'PHP Developer',
        ],
    ];

    /**
     * @var array<int, string>
     */
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
