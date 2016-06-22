<?php namespace MrCoffer\Tests;

use Closure;
use Mockery;
use Mockery\Mock;
use MrCoffer\Http\Middleware\Authenticate;
use PHPUnit_Framework_TestCase as PHPUnit;

/**
 * Class AuthenticateTest
 * 
 * @package MrCoffer\Tests
 */
class AuthenticateTest extends PHPUnit
{
    /**
     * Middleware we are testing.
     *
     * @var Authenticate
     */
    protected $authenticate;

    /**
     * Mock Authentication Manager service.
     *
     * @var Mock
     */
    protected $authManager;

    /**
     * Mock Http Response service.
     *
     * @var Mock
     */
    protected $response;

    /**
     * Mock Http Request service.
     *
     * @var Mock
     */
    protected $request;

    /**
     * Mock Route Redirect Service.
     *
     * @var Mock
     */
    protected $redirect;

    /**
     * Mock callable Closure returned if the Request
     * passed the middleware.
     *
     * @var Closure
     */
    protected $next;

    /**
     * Initialize our mock services and instantiate the middleware for testing.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->authManager = Mockery::mock('Illuminate\Auth\AuthManager');
        $this->response = Mockery::mock('Illuminate\Http\Response');
        $this->request = Mockery::mock('Illuminate\Http\Request');
        $this->redirect = Mockery::mock('Illuminate\Routing\Redirector');
        $this->next = function() {
           return true;
        };

        $this->authenticate = new Authenticate($this->authManager, $this->response, $this->redirect);
    }

    /**
     * Clean up properties.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->authenticate);
    }

    /**
     * Test that the Authenticate middleware will reject requests for AJAX or JSON
     * and return a 401 response.
     *
     * @return void
     */
    public function testMiddlewareRejectsGuestAjaxJson()
    {
        // Assert that the requesting User is a guest.
        $this->authManager->shouldReceive('guard->guest')->andReturn(true);

        // The Request service should report that this is an AJAX and a JSON request.
        $this->request->shouldReceive('ajax')->andReturn(true);
        $this->request->shouldReceive('wantsJson')->andReturn(true);

        // We should therefore send a 401 response.
        $this->response->shouldReceive('setContent');
        $this->response->shouldReceive('setStatusCode')->with(401);
        $this->response->shouldReceive('send')->andReturn(true);
        
        $this->assertTrue($this->authenticate->handle($this->request, $this->next, null));
    }

    /**
     * Test that the Authenticate middleware will route a guest User
     * back to the login route.
     *
     * @return void
     */
    public function testMiddlewareRoutesGuestToLogin()
    {
        // Assert that the requesting User is a guest.
        $this->authManager->shouldReceive('guard->guest')->andReturn(true);
        
        // Indicate that this is not an AJAX nor JSON request.
        $this->request->shouldReceive('ajax')->andReturn(false);
        $this->request->shouldReceive('wantsJson')->andReturn(false);
        
        // The User should be redirected to Login.
        $this->redirect->shouldReceive('guest')->with('login')->andReturn(true);
        
        $this->assertTrue($this->authenticate->handle($this->request, $this->next, null));
    }

    /**
     * Test that a User is able to proceed if the Authentication Manager
     * reports that they are not a guest.
     *
     * @return void
     */
    public function testUserIsAuthenticated()
    {
        // Assert that the User is not a guest.
        $this->authManager->shouldReceive('guard->guest')->andReturn(false);

        // Assert that the 'next' closure is returned.
        $this->assertTrue($this->authenticate->handle($this->request, $this->next, null));
    }
}