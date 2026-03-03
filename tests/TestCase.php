<?php

declare(strict_types = 1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /**
     * @var \App\Models\User|null
     */
    // phpcs:ignore SlevomatCodingStandard.Classes.ForbiddenPublicProperty.ForbiddenPublicProperty -- set by Pest beforeEach, read in tests
    public $user;

    /**
     * @var array{name: string, email: string, password: string, password_confirmation: string}|null
     */
    // phpcs:ignore SlevomatCodingStandard.Classes.ForbiddenPublicProperty.ForbiddenPublicProperty -- set by Pest beforeEach, read in tests
    public $userData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

}
