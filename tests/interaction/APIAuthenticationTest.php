<?php

namespace MrCoffer\Tests;

use MrCoffer\User;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class APIAuthenticationTest
 * Tests that a client of our API is able to retrieve an access token with
 * valid credentials and use said token to access a protected route.
 */
class APIAuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * User of our application that has been created
     * and saved to the database.
     *
     * @var User
     */
    protected $user;

    /**
     * Oauth client that will authorize
     * our Users.
     *
     * @var Client
     */
    protected $apiClient;

    /**
     * Initialize requirements for these tests.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // Make a new User and save it to the database.
        $this->user = factory(User::class)->create();

        // We are using the Laravel/Passport package to manage our API authentication
        // therefore we must install it in order to retrieve any tokens.
        Artisan::call('passport:install');

        $client = new Client();
        $this->apiClient = $client->newQuery()->where('name', ' Password Grant Client')->firstOrFail();
    }

    /**
     * Clean up this test once we are done.
     *
     * @return void
     */
    public function tearDown()
    {
        $this->user->delete();

        parent::tearDown();
    }

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

    /**
     * Test that the User is able to log in using an email / password, retrieve
     * a token, then use that Token to view a protected route.
     *
     * @return void
     */
    public function testUserCanSeeProtectedRouteWithToken()
    {
        // The data that a User would submit
        // to us from a web form.
        $formData = [
            'grant_type'        => 'password',
            'client_id'         => $this->apiClient->getAttribute('id'),
            'client_secret'     => $this->apiClient->getAttribute('secret'),
            'username'          => $this->user->getAttribute('email'),
            'password'          => $this->user->getAttribute('password'),
        ];

        // The message that should be received if we have successfully authenticated.
        $authorizedMessage = "You have arrived {$this->user->getAttribute('name')}.";

        $this->json('POST', '/', $formData)->see($authorizedMessage);
    }
}
