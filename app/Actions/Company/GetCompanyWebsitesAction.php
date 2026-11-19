<?php

declare(strict_types = 1);

namespace App\Actions\Company;

use Illuminate\Support\Facades\Lang;
use Pekral\Arch\Action\ArchAction;

final readonly class GetCompanyWebsitesAction implements ArchAction
{

    /**
     * @return array<string, string> company name => website URL, only for companies that have a website
     */
    public function execute(): array
    {
        $experiences = Lang::get('guest.about.experiences');
        assert(is_array($experiences));
        $websites = [];

        foreach (array_column($experiences, 'website', 'company') as $company => $website) {
            if (is_string($website) && filled($website)) {
                $websites[(string) $company] = $website;
            }
        }

        return $websites;
    }

}
