<?php

declare(strict_types=1);

namespace BehatTests;

use App\Creators\UserCreator;
use Behat\Behat\Context\Context;
use Exception;

/**
 * Class AuthenticationContext
 * @package BehatTests
 */
class AuthenticationContext implements Context
{
    /**
     * @Given user with email :email and password :password exists
     * @param string $email
     * @param string $password
     * @return void
     * @throws Exception
     */
    public function userWithEmailAndPasswordExists(string $email, string $password): void
    {
        /** @var UserCreator $creator */
        $creator = app()->make(UserCreator::class);
        $creator->createOrReplaceUser($email, $password);
    }

    /**
     * @Given user with email :email not exists
     * @param string $email
     * @return void
     * @throws Exception
     */
    public function userWithEmailNotExists(string $email): void
    {
        /** @var UserCreator $creator */
        $creator = app()->make(UserCreator::class);
        $creator->removeUserIfExists($email);
    }
}
