<?php namespace MrCoffer\Tests;

use Closure;
use Mockery;
use Mockery\Mock;
use MrCoffer\Http\Middleware\Authenticate;

/**
 * Class AuthenticateTest
 * 
 * @package MrCoffer\Tests
 */
class AuthenticateTest extends TestCase
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
        $this->next = function($request) {
           return $request;
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
        $this->response->shouldReceive('send');
    }
}