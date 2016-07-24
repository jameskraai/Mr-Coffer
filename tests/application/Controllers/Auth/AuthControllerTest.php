<?php

namespace MrCoffer\Tests;

use Faker\Factory as FakerFactory;
use Faker\Generator as Faker;
use Mockery;
use Mockery\Mock;
use MrCoffer\Http\Controllers\Auth\AuthController;
use PHPUnit_Framework_TestCase as PHPUnit;
use ReflectionMethod;

/**
 * Class AuthControllerTest
 */
class AuthControllerTest extends PHPUnit
{
    /**
     * Mock User model instance.
     *
     * @var Mock
     */
    protected $user;

    /**
     * Mock Validator Factory instance.
     *
     * @var Mock
     */
    protected $validatorFactory;

    /**
     * Controller instance we are testing against.
     *
     * @var AuthController
     */
    protected $authController;

    /**
     * Handy service we will use to make stub data.
     *
     * @var Faker
     */
    protected $faker;

    /**
     * Initialize our mock services and make the Controller for testing.
     *
     * @return void
     */
    public function setUp()
    {
        $this->user = Mockery::mock('MrCoffer\User');
        $this->validatorFactory = Mockery::mock('Illuminate\Validation\Factory');
        $this->authController = new AuthController($this->user, $this->validatorFactory);
        $this->faker = FakerFactory::create();
    }

    /**
     * Unset any mock objects and remove the Controller.
     *
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
        unset($this->authController);
    }

    /**
     * Test that the validator method will call the Validator Factory
     * to make a new instance with the correct rules.
     *
     * @return void
     */
    public function testValidatorSetsUpRules()
    {
        // Array of data that will be passed from the Request.
        $requestData = ['Request array'];

        // Rules of the Validator;
        $validatorRules = [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ];

        // Return true in this test case.
        $this->validatorFactory->shouldReceive('make')->withArgs([$requestData, $validatorRules])->andReturn(true);

        // Since the method is protected we must use reflection to be able to invoke it.
        $method = new ReflectionMethod(AuthController::class, 'validator');

        // Configure the method to be accessible.
        $method->setAccessible(true);

        // Invoke the method and assert that the result is true.
        $this->assertTrue($method->invoke($this->authController, $requestData));
    }

    /**
     * Test that the data from the Request is able to parsed and added to a User
     * model, saved, and then returned from the method.
     *
     * @return void
     */
    public function testCreateMethodSavesNewUser()
    {
        // Array of data from the Http Request with new User information.
        $requestData = [
            'name'     => $this->faker->name,
            'email'    => $this->faker->email,
            'password' => $this->faker->password(6, 20)
        ];

        // Assert that the properties are set on the User.
        $this->user->shouldReceive('setAttribute')->withArgs(['name', $requestData['name']]);
        $this->user->shouldReceive('setAttribute')->withArgs(['email', $requestData['email']]);
        $this->user->shouldReceive('setAttribute')->withArgs(['password', $requestData['password']]);
        $this->user->shouldReceive('save');

        // Since the method is protected we must use reflection to grab it.
        $method = new ReflectionMethod(AuthController::class, 'create');

        // Configure the method to be accessible.
        $method->setAccessible(true);

        // Invoke the method and assert that our mock User is returned.
        $this->assertEquals($this->user, $method->invoke($this->authController, $requestData));
    }
}
