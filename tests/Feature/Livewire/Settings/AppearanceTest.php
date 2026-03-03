<?php

declare(strict_types = 1);

use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    /** @var \Tests\TestCase $this */
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

it('renders appearance component', function (): void {
    /** @var \Tests\TestCase $this */
    $response = $this->get(route('settings.appearance'));
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertStatus(200)->assertSeeLivewire('settings.appearance');
});

it('displays appearance options', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.appearance');
    $component->assertSee('Light');
    $component->assertSee('Dark');
    $component->assertSee('System');
});

it('has appearance selection controls', function (): void {
    /** @var \Livewire\Features\SupportTesting\Testable<\Livewire\Component> $component */
    $component = Livewire::test('settings.appearance');
    $component->assertSee('Light');
    $component->assertSee('Dark');
    $component->assertSee('System');
});
