<?php namespace MrCoffer\Tests\AccountController;

use Mockery;
use Mockery\Mock;
use PHPUnit_Framework_TestCase as PHPUnit;
use MrCoffer\Http\Controllers\Account\StoreController;

/**
 * Class StoreControllerTest
 * Any tests concerning the Account\StoreController class may live here.
 *
 * @package MrCoffer\Tests\AccountController
 */
class StoreControllerTest extends PHPUnit
{

    /**
     * Auth Manager service that the controller requires in
     * order to fetch the currently authenticated User.
     *
     * @var Mock
     */
    private $authManager;

    /**
     * Returned User model from the Auth Manager.
     *
     * @var Mock
     */
    private $authenticatedUser;

    /**
     * Fresh Account model instance that will be assigned attributes
     * and called to save a new database record.
     *
     * @var Mock
     */
    private $newAccount;

    /**
     * Http Request service used to parse data from the post form.
     *
     * @var Mock
     */
    private $request;

    /**
     * Used to set up and send Http redirects from our controller.
     *
     * @var Mock
     */
    private $redirect;

    /**
     * Used to make fresh Validator instances.
     *
     * @var Mock
     */
    private $validatorFactory;

    /**
     * Returned Validator mock instance from the Validator Factory.
     *
     * @var Mock
     */
    private $validator;

    /**
     * Instance of the Controller to test against.
     *
     * @var StoreController
     */
    private $storeController;

    /**
     * Set up all of the services this controller requires.
     *
     * @return void
     */
    public function setUp()
    {
        // Set up mock instances of all required services.
        $this->authManager = Mockery::mock('Illuminate\Auth\AuthManager');
        $this->authenticatedUser = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $this->newAccount = Mockery::mock('MrCoffer\Account\Account');
        $this->request = Mockery::mock('Illuminate\Http\Request');
        $this->redirect = Mockery::mock('Illuminate\Routing\Redirector');
        $this->validatorFactory = Mockery::mock('Illuminate\Validation\Factory');
        $this->validator = Mockery::mock('Illuminate\Validation\Validator');

        $this->storeController = new StoreController(
            $this->authManager,
            $this->request,
            $this->redirect,
            $this->validatorFactory
        );
    }

    /**
     * Close out mock instances.
     *
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
        unset($this->storeController);
    }

    /**
     * Test the upon instantiation the Controller is setup and the middleware is set.
     *
     * @return void
     */
    public function testControllerSetupMiddlewareSet()
    {
        $controller = new StoreController($this->authManager, $this->request, $this->redirect, $this->validatorFactory);

        $this->assertInstanceOf(StoreController::class, $controller);
    }


    /**
     * Test that an Account can be saved based on values from the Http Request and the Validator passes,
     * then insert the new Account into the database, then the User is redirected back to the dashboard.
     *
     * @covers MrCoffer\Http\Controllers\Account\StoreController::store
     * @return void
     */
    public function testAccountSavedValidatorPasses()
    {
        // Set up some variables to be used on the new Account.
        $name = 'New Account';
        $number = 1111;
        $accountTypeID = 1;
        $bankID = 1;

        // The User will receive a request for it's ID attribute.
        $this->authenticatedUser->shouldReceive('getAttribute')->once()->andReturn(10);

        // The Auth Manager will receive a request to get the currently authenticated User
        // and will then return a new User eloquent model.
        $this->authManager->shouldReceive('guard->user')->once()->andReturn($this->authenticatedUser);

        // The Account should have the currently authenticated User ID set as an attribute.
        $this->newAccount->shouldReceive('setAttribute')->withArgs(['user_id', 10]);

        // 'all' will be called on the Request service.
        $this->request->shouldReceive('all')->withNoArgs()->andReturn([]);
        $this->request->shouldReceive('input')->with('name')->andReturn($name);
        $this->request->shouldReceive('input')->with('number')->andReturn($number);
        $this->request->shouldReceive('input')->with('account-type')->andReturn($accountTypeID);
        $this->request->shouldReceive('input')->with('bank')->andReturn($bankID);

        // The Validator Factory will make a new Validator with the Request and rules and will return a Validator.
        $this->validatorFactory->shouldReceive('make')->once()->andReturn($this->validator);

        // In this test the Validator will pass.
        $this->validator->shouldReceive('fails')->andReturn(false);

        // Since the Request passed validation we can safely set the values as attributes
        // on the new Account model.
        $this->newAccount->shouldReceive('setAttribute')->withArgs(['name', $name]);
        $this->newAccount->shouldReceive('setAttribute')->withArgs(['number', $number]);
        $this->newAccount->shouldReceive('setAttribute')->withArgs(['type_id', $accountTypeID]);
        $this->newAccount->shouldReceive('setAttribute')->withArgs(['bank_id', $bankID]);

        // The new Account should be saved to the database.
        $this->newAccount->shouldReceive('save')->once()->withNoArgs();

        // Finally a Redirect Response should be returned to the dashboard route.
        $this->redirect->shouldReceive('route')->with('dashboard')->once()->andReturn(true);

        $this->assertTrue($this->storeController->store($this->newAccount));
    }

    /**
     * Test that if the Validator fails then the User is returned back to the account create view.
     *
     * @covers MrCoffer\Http\Controllers\Account\StoreController::store
     * @return void
     */
    public function testValidatorFails()
    {
        // The User will receive a request for it's ID attribute.
        $this->authenticatedUser->shouldReceive('getAttribute')->once()->andReturn(10);

        // The Auth Manager will receive a request to get the currently authenticated User
        // and will then return a new User eloquent model.
        $this->authManager->shouldReceive('guard->user')->once()->andReturn($this->authenticatedUser);

        // The Account should have the currently authenticated User ID set as an attribute.
        $this->newAccount->shouldReceive('setAttribute')->withArgs(['user_id', 10]);

        // 'all' will be called on the Request service.
        $this->request->shouldReceive('all')->withNoArgs()->andReturn([]);

        // The Validator Factory will make a new Validator with the Request and rules and will return a Validator.
        $this->validatorFactory->shouldReceive('make')->once()->andReturn($this->validator);

        // In this test the validator will fail.
        $this->validator->shouldReceive('fails')->andReturn(true);

        // Assert that the User will be redirected back to the account.create view.
        $this->redirect->shouldReceive('route->withErrors->withInput')->once()->andReturn(true);

        $this->assertTrue($this->storeController->store($this->newAccount));
    }
}
