<?php namespace MrCoffer\Tests;

use Mockery;
use Mockery\Mock;
use MrCoffer\Http\Controllers\Account\ShowController;

/**
 * Class ShowControllerTest
 * Test the logical controller methods that handle the incoming requests and return the view.
 *
 * @package MrCoffer\Tests
 */
class ShowControllerTest extends TestCase
{
    /**
     * Account model instance.
     *
     * @var Mock
     */
    protected $account;

    /**
     * Mock Access Gate service.
     *
     * @var Mock
     */
    protected $gate;

    /**
     * Mock View Factory service.
     *
     * @var Mock
     */
    protected $viewFactory;

    /**
     * Mock Http Redirect service.
     *
     * @var Mock
     */
    protected $redirect;

    /**
     * Controller instance.
     *
     * @var ShowController
     */
    protected $showCtrl;

    /**
     * Set up our mock services and init our controller for testing.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->account = Mockery::mock('MrCoffer\Account\Account');
        $this->gate = Mockery::mock('Illuminate\Contracts\Auth\Access\Gate');
        $this->viewFactory = Mockery::mock('Illuminate\Contracts\View\Factory');
        $this->redirect = Mockery::mock('Illuminate\Routing\Redirector');
        $this->showCtrl = new ShowController(
            $this->account,
            $this->gate,
            $this->viewFactory,
            $this->redirect
        );
    }

    /**
     * Remove any mock services and our controller instance.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
        unset($this->showCtrl);
    }

    /**
     * Test that an authorized User can view an Account they own.
     *
     * @return void
     */
    public function testAuthorizedUserCanViewAccount()
    {
        $this->account->shouldReceive('query->where->firstOrFail')->andReturn('Found Account');
        $this->gate->shouldReceive('denies')->withArgs(['canShow', 'Found Account'])->andReturn(false);
        $this->viewFactory->shouldReceive('make')->withArgs(['account.show', ['account' => 'Found Account']])->andReturn(true);

        $this->assertTrue($this->showCtrl->show(1));
    }
}