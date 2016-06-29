<?php namespace MrCoffer\Tests;

use Mockery;
use Mockery\Mock;
use ReflectionMethod;
use Faker\Generator as Faker;
use Faker\Factory as FakerFactory;
use PHPUnit_Framework_TestCase as PHPUnit;
use MrCoffer\Http\Controllers\Auth\AuthController;

/**
 * Class AuthControllerTest
 *
 * @package MrCoffer\Tests
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
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
}
