<?php namespace MrCoffer\Tests\AccountController;

use Mockery;
use Mockery\Mock;
use PHPUnit_Framework_TestCase as PHPUnit;
use MrCoffer\Http\Controllers\Account\CreateController;

/**
 * Class CreateControllerTest
 * Test that the Controller will gather all of the required information and make a new view
 * to be sent to the User so they can create a new Account.
 *
 * @package MrCoffer\Tests\AccountController
 */
class CreateControllerTest extends PHPUnit
{
    /**
     * Mock Bank model.
     *
     * @var Mock
     */
    private $bank;

    /**
     * Mock Account Type model.
     *
     * @var Mock
     */
    private $accountType;

    /**
     * Mock View Factory service instance.
     *
     * @var Mock
     */
    private $viewFactory;

    /**
     * Controller instance to test against.
     *
     * @var CreateController
     */
    private $createController;

    /**
     * Create the Controller for testing and the required
     * mock services.
     */
    public function setUp()
    {
        $this->bank = Mockery::mock('MrCoffer\Bank');
        $this->accountType = Mockery::mock('MrCoffer\Account\Type');
        $this->viewFactory = Mockery::mock('Illuminate\View\Factory');
        $this->createController = new CreateController($this->bank, $this->accountType);
    }

    /**
     * Close out Mockery and unset our Controller instance.
     *
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
        unset($this->createController);
    }

    /**
     * Test that a new View is returned with all of the required data.
     *
     * @return void
     */
    public function testViewCreatedWithAllBanksTypes()
    {
        // The Controller will request all of the models, for this test let's just return true.
        $this->accountType->shouldReceive('all')->andReturn(true);
        $this->bank->shouldReceive('all')->andReturn(true);

        // This is the data we are expecting the controller to set up and inject into the view.
        $expectedData = ['accountTypes' => true, 'banks' => true];

        // Assert that a new View Instance is made with our data.
        $this->viewFactory->shouldReceive('make')->withArgs(['account.create', $expectedData])->andReturn(true);

        // Assert that our create method returns true.
        $this->assertTrue($this->createController->create($this->viewFactory));
    }

}