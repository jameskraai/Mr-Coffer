<?php namespace MrCoffer\Tests;

use Closure;
use Mockery;
use Mockery\Mock;
use PHPUnit_Framework_TestCase as PHPUnit;
use MrCoffer\Http\Middleware\RedirectIfAuthenticated;

/**
 * Class RedirectIfAuthenticatedTest
 *
 * @package MrCoffer\Tests
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
        $this->next = Mockery::mock('Closure')->makePartial();

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
}