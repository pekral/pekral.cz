<?php

declare(strict_types = 1);

use App\Actions\Company\GetCompanyWebsitesAction;

it('maps the companies of the timeline that have a website to that website', function (): void {
    $websites = app(GetCompanyWebsitesAction::class)->execute();

    expect($websites)->toHaveKey('ECOMAIL.CZ', 'https://ecomail.cz')
        ->and($websites)->toHaveKey('Slevomat', 'https://www.slevomat.cz')
        ->and($websites)->not->toHaveKey('Self-employed');
});
