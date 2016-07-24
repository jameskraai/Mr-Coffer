<?php

namespace MrCoffer\Tests;

use Closure;
use Mockery;
use Mockery\Mock;
use MrCoffer\Http\Middleware\RedirectIfAuthenticated;
use PHPUnit_Framework_TestCase as PHPUnit;

/**
 * Class RedirectIfAuthenticatedTest.
 */
class RedirectIfAuthenticatedTest extends PHPUnit
{
    /**
     * Middleware we are testing.
     *
     * @var RedirectIfAuthenticated
     */
    protected $redirectIfAuthenticated;

    /**
     * Mock Authentication Manager service.
     *
     * @var Mock
     */
    protected $authManager;

    /**
     * Mock Redirect service.
     *
     * @var Mock
     */
    protected $redirect;

    /**
     * Mock Http Request service.
     *
     * @var Mock
     */
    protected $request;

    /**
     * Closure returned from the middleware if the User
     * is not logged in and routed to the dashboard.
     *
     * @var Closure
     */
    protected $next;

    /**
     * Initialize our mock services and set up our
     * middleware instance to test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // Set up our mock services, these are injected into the
        // RedirectIfAuthenticated class so that we can easily
        // set expectations on them in our tests.
        $this->request = Mockery::mock('Illuminate\Http\Request');
        $this->redirect = Mockery::mock('Illuminate\Routing\Redirector');
        $this->authManager = Mockery::mock('Illuminate\Auth\AuthManager');

        // Unfortunately the Closure class is marked as 'final' therefore we cannot mock it.
        // So then we will simply pass our own closure which returns true for this test.
        $this->next = function () {
            return true;
        };

        // Instantiate our middleware class with the required dependencies.
        $this->redirectIfAuthenticated = new RedirectIfAuthenticated($this->authManager, $this->redirect);
    }

    /**
     * Clean up properties and remove middleware instance.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        unset($this->next);
        unset($this->redirectIfAuthenticated);
    }

    /**
     * Test that an authenticated User is routed to the dashboard.
     *
     * @return void
     */
    public function testAuthenticatedUserRoutedToDashboard()
    {
        // Set the expectation that the Auth Manager is asked if the received
        // guard argument is authenticated, in this test the User is
        // therefore we return true.
        $this->authManager->shouldReceive('guard->check')->andReturn(true);

        // The Redirect service should receive a request to route the User to the dashboard.
        // For this test we will return true so that we can assert that the expected
        // value is returned from the method.
        $this->redirect->shouldReceive('route')->with('dashboard')->andReturn(true);

        // Assert that the handle method returns true which is what our redirect mock service should
        // return as the Auth Manager should report that the User is authenticated.
        $this->assertTrue($this->redirectIfAuthenticated->handle($this->request, $this->next, null));
    }

    /**
     * Test that the handle method will move on with the next request if the
     * Auth Manager reports that the User is a guest (not logged in).
     *
     * @return void
     */
    public function testHandleMovesOnIfGuest()
    {
        // Set the Auth Manager to return false upon checking the guest (indicating the User is a guest).
        $this->authManager->shouldReceive('guard->check')->andReturn(false);

        // In order to move on to the next request our 'handle' method will invoke the $next Closure
        // and return us the result. For this test our $next Closure simply returns true.
        $this->assertTrue($this->redirectIfAuthenticated->handle($this->request, $this->next, null));
    }
}
