<?php

declare(strict_types=1);

namespace BehatTests;

use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;

/**
 * Class TestContext
 * @package BehatTests
 */
class TestContext implements Context
{
    /**
     * @Given user with email :email and username :username
     * @param string $email
     * @param string $username
     */
    public function userWithEmailAndUsername($email, $username): void
    {
        Assert::assertEquals($username . '@example.com', $email);
    }
}
