<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use App\Creators\UserCreator;
use Exception;

/**
 * Trait Requesting
 * @package BehatTests\helpers
 */
trait Users
{
    /**
     * @Given user with email :email and password :password exists
     * @Given user with email :email exists
     * @param string $email
     * @param string $password
     * @return void
     * @throws Exception
     */
    public function userWithEmailAndPasswordExists(string $email, string $password = 'secret'): void
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

    /**
     * @Given authenticated by email :email and password :password
     * @param string $email
     * @param string $password
     * @throws Exception
     */
    public function authenticatedByEmailAndPassword(string $email, string $password): void
    {
        $this->userWithEmailAndPasswordExists($email, $password);
        $jwtToken = auth()->attempt(['email' => $email, 'password' => $password]);

        $this->request->headers->add(['Authorization' => 'Bearer ' . $jwtToken]);
    }
}
