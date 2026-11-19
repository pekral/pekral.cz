<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    Cache::flush();
});

test('json-ld never lets a github description break out of the script block', function (): void {
    Http::fake([
        'api.github.com/users/pekral/repos*' => Http::response([
            [
                'name' => 'hostile',
                'description' => '</script><script>alert(1)</script> & co',
                'html_url' => 'https://github.com/pekral/hostile',
                'language' => 'PHP',
            ],
        ], 200),
        'raw.githubusercontent.com/*' => Http::response([], 404),
    ]);

    /** @var \Tests\TestCase $this */
    $response = $this->get('/projects/hostile');
    /** @var \Illuminate\Testing\TestResponse<\Symfony\Component\HttpFoundation\Response> $response */
    $response->assertSuccessful();
    $response->assertDontSee('</script><script>alert(1)', escape: false);
    $response->assertSee('\\u003C/script\\u003E', escape: false);
});
