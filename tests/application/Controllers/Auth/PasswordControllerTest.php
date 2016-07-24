<?php

namespace MrCoffer\Tests;

use MrCoffer\Http\Controllers\Auth\PasswordController;
use PHPUnit_Framework_TestCase as PHPUnit;

/**
 * Class PasswordControllerTest.
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

