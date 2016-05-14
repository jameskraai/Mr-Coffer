<?php namespace MrCoffer\Tests\AccountController;

use MrCoffer\User;
use MrCoffer\Bank;
use MrCoffer\Tests\TestCase;
use MrCoffer\Account\Type as AccountType;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
     * Factory created Account Type Eloquent Model.
     *
     * @var AccountType
     */
    public $accountType;

    /**
     * Factory created Bank Model.
     *
     * @var Bank
     */
    public $bank;

    /**
     * Pre-test setting up.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        // Generate the temporary Eloquent Models that are required
        // to test this Http Controller.
        $this->accountType = factory(AccountType::class)->create();
        $this->bank = factory(Bank::class)->create();
        $this->user = factory(User::class)->create();
    }

    /**
     * Test that the the new Account.create view is ble to be used
     * to successfully create a new Account instance.
     *
     * @return void
     */
    public function testAccountCanBeMade()
    {
        // The following portion tests that an authenticated User is able to visit the 'account/create' view
        // then fill out the form with valid values and then save - of which then a new Account is saved
        // to the database and the User is redirect back to the dashboard without error.
        $this->actingAs($this->user);
        $this->visit('account/create');
        $this->type('New Account', 'name');
        $this->type(2143, 'number');
        $this->select($this->accountType->getAttribute('id'), 'account-type');
        $this->select($this->bank->getAttribute('id'), 'bank');
        $this->press('save');
        $this->seePageIs('/dashboard');

        // Check to see if the new Account was indeed saved to the database.
        $this->seeInDatabase('accounts', ['name' => 'New Account']);
    }
}
