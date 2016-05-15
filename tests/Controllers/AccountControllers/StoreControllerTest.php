<?php namespace MrCoffer\Tests\AccountController;

use Mockery;
use Mockery\Mock;
use MrCoffer\User;
use MrCoffer\Bank;
use MrCoffer\Tests\TestCase;
use MrCoffer\Account\Type as AccountType;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use MrCoffer\Http\Controllers\Account\StoreController;

/**
 * Class StoreControllerTest
 * Any tests concerning the Account\StoreController class may live here.
 *
 * @package MrCoffer\Tests\AccountController
 */
class StoreControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Auth Manager service that the controller requires in
     * order to fetch the currently authenticated User.
     *
     * @var Mock
     */
    public $authManager;

    /**
     * Returned User model from the Auth Manager.
     *
     * @var Mock
     */
    public $authenticatedUser;

    /**
     * Fresh Account model instance that will be assigned attributes
     * and called to save a new database record.
     *
     * @var Mock
     */
    public $newAccount;

    /**
     * Http Request service used to parse data from the post form.
     *
     * @var Mock
     */
    public $request;

    /**
     * Used to set up and send Http redirects from our controller.
     *
     * @var Mock
     */
    public $redirect;

    /**
     * Used to make fresh Validator instances.
     *
     * @var Mock
     */
    public $validatorFactory;

    /**
     * Returned Validator mock instance from the Validator Factory.
     *
     * @var Mock
     */
    public $validator;

    /**
     * Set up all of the services this controller requires.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // Set up mock instances of all required services.
        $this->authManager = Mockery::mock('Illuminate\Auth\AuthManager');
        $this->authenticatedUser = Mockery::mock('Illuminate\Database\Eloquent\Model');
        $this->newAccount = Mockery::mock('MrCoffer\Account\Account');
        $this->request = Mockery::mock('Illuminate\Http\Request');
        $this->redirect = Mockery::mock('Illuminate\Routing\Redirector');
        $this->validatorFactory = Mockery::mock('Illuminate\Validation\Factory');
        $this->validator = Mockery::mock('Illuminate\Validation\Validator');
    }

    /**
     * Close out mock instances.
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Mockery::close();
    }

    /**
     * Test that the the new Account.create view is ble to be used
     * to successfully create a new Account instance.
     *
     * @return void
     */
    public function testAccountCanBeMade()
    {
        $accountType = factory(AccountType::class)->create();
        $bank = factory(Bank::class)->create();
        $user = factory(User::class)->create();

        // The following portion tests that an authenticated User is able to visit the 'account/create' view
        // then fill out the form with valid values and then save - of which then a new Account is saved
        // to the database and the User is redirect back to the dashboard without error.
        $this->actingAs($user);
        $this->visit('account/create');
        $this->type('New Account', 'name');
        $this->type(2143, 'number');
        $this->select($accountType->getAttribute('id'), 'account-type');
        $this->select($bank->getAttribute('id'), 'bank');
        $this->press('save');
        $this->seePageIs('/dashboard');

        // Check to see if the new Account was indeed saved to the database.
        $this->seeInDatabase('accounts', ['name' => 'New Account']);
    }

    /**
     * Test that an Account can be saved based on values from the Http Request and the Validator passes,
     * then insert the new Account into the database, then the User is redirected back to the dashboard.
     *
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

        // Make the Account\StoreController
        $storeController = new StoreController($this->authManager, $this->request, $this->redirect, $this->validatorFactory);

        $this->assertTrue($storeController->store($this->newAccount));
    }
}
