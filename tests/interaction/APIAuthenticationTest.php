<?php

namespace MrCoffer\Tests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class APIAuthenticationTest
 * Tests that a client of our API is able to retrieve an access token with
 * valid credentials and use said token to access a protected route.
 */
class APIAuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that when an un-authenticated User tries to access
     * a protected route our application will return
     * an 'unauthorized' response.
     *
     * @return void
     */
    public function testUserMustBeAuthenticated()
    {
        $this->json('GET', '/')->see('Unauthorized');
    }
}
