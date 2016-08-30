<?php

namespace MrCoffer\Tests;

use MrCoffer\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class DashboardTest
 * Tests any action a User may take when logged into the Dashboard route.
 */
class DashboardTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test that the User is able to log out from the dashboard.
     *
     * @return void
     */
    public function testUserCanLogOut()
    {
        // Create a new User in the database for
        // us to authenticate as for this test.
        $user = factory(User::class)->create();

        // Visit the application as our new User.
        $this->actingAs($user);

        // Visit the dashboard.
        $this->visit('/dashboard');

        // Click the logout button.
        $this->click('#logout');

        // Assert that the page we are on is the login page.
        $this->seePageIs('/login');

        // Verify that are in fact no longer logged in.
        $this->assertFalse($this->isAuthenticated());
    }
}