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
     * Test that the the new Account.create view is ble to be used
     * to successfully create a new Account instance.
     *
     * @return void
     */
    public function testAccountCanBeMade()
    {
        // First for the sake of this test we need to set up a
        // few temporary models and save them to the database.
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
}
