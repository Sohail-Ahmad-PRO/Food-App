<?php

namespace Tests;

use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class BaseTestCase
 * @package Tests
 */
class BaseTestCase extends TestCase
{
    use RefreshDatabase;

    protected static bool $initialized = false;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate');

        if (!static::$initialized) {
            $this->artisan('db:seed');
            static::$initialized = true;
        }

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->withoutMiddleware(VerifyCsrfToken::class);
    }
}
