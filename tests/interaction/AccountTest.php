<?php namespace MrCoffer\Tests;

use Mockery;
use MrCoffer\Bank;
use MrCoffer\User;
use MrCoffer\Account\Account;
use MrCoffer\Account\Type as AccountType;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class AccountTest
 * These tests concern any action the User can take on the Account page.
 *
 * @package MrCoffer\Tests
 */
class AccountTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * User model instance.
     *
     * @var User
     */
    protected $user;

    /**
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // Init a new User.
        $this->user = new User();
    }

    /**
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();

        // Remove the User.
        unset($this->user);
    }

    /**
     * Test that the the new Account.create view is ble to be used
     * to successfully create a new Account instance.
     *
     * @covers MrCoffer\Http\Controllers\Account\StoreController::store
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
     * Test that an authenticated User is able to view their own Account.
     *
     * @return void
     */
    public function testAuthUserCanViewOwnAccount()
    {
        /** @var Account $account */
        $account = factory(Account::class)->create();

        // Grab the User ID attribute that was created on the Account model.
        $userID = $account->getAttribute('user_id');
        $accountID = $account->getAttribute('id');

        /**
         * With the User ID attribute on the Account, use it to find the User model
         * in the database and make a new Eloquent Model from it. We will use this
         * to authenticate into our app as the User that owns the Account.
         *
         * @var User $user
         */
        $user = $this->user->newQuery()->findOrFail($userID);

        // Log in to the app as the User we found in the database.
        $this->actingAs($user);

        // Visit the specific Account page.
        $this->visit("account/{$accountID}");

        // Since this User owns the Account we are allowed to see it.
        $this->seePageIs("account/{$accountID}");
    }

    /**
     * Test that an unauthorized User can not view an
     * Account that they do not own.
     *
     * @return void
     */
    public function testUnauthorizedUserCannotViewAccount()
    {
        /** @var Account $account */
        $account = factory(Account::class)->create();

        /** @var User $user */
        $user = factory(User::class)->create();

        // Visit our app as the new User.
        $this->actingAs($user);

        // As new User try to visit the Account that was created.
        $this->visit("account/{$account->getAttribute('id')}");

        // Since the Account did not belong to the User the application
        // should route us back to the dashboard.
        $this->seePageIs("dashboard");
    }
}

