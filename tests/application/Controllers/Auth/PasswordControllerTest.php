<?php namespace MrCoffer\Tests;

use PHPUnit_Framework_TestCase as PHPUnit;
use MrCoffer\Http\Controllers\Auth\PasswordController;

/**
 * Class PasswordControllerTest
 *
 * @package MrCoffer\Tests
 */
class PasswordControllerTest extends PHPUnit
{
    /**
     * Test that the new controller can be made
     * and the appropriate middleware set.
     */
    public function testNewControllerInstanceCanBeMade()
    {
        $controller = new PasswordController();

        $this->assertInstanceOf(PasswordController::class, $controller);
    }
}

