<?php

declare(strict_types=1);

namespace BehatTests\helpers;

use App\Creators\UserCreator;
use App\Models\Friend;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Trait Users
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


    /**
     * @Given I am logged in as :roleName
     * @param string $roleName
     * @throws Exception
     */
    public function loggedInAsRole(string $roleName): void
    {
        if (auth()->check()) {
            auth()->logout();
        }

        $this->authenticatedByEmailAndPassword($roleName . '@example.com', 'secret');

        $user = auth()->user();

        if ($roleName === 'Admin') {
            $user->is_admin = true;
        } else {
            $user->is_admin = false;
        }

        $user->save();
    }

    /**
     * @Given user with id :id is friend
     * @param int $id
     */
    public function userWithIdIsFriend(int $id): void
    {
        Friend::updateOrCreate([
            'user_id' => auth()->id(),
            'friend_id' => $id,
        ], [
            'accepted_at' => Carbon::now()
        ]);
    }

    /**
     * @Given user with id :id is not friend
     * @param int $id
     */
    public function userWithIdIsNotFriend(int $id): void
    {
        Friend::updateOrCreate([
            'user_id' => auth()->id(),
            'friend_id' => $id,
        ], [
            'accepted_at' => null
        ]);
    }

    /**
     * @Given user with id :id exist
     * @param int $id
     * @throws BindingResolutionException
     */
    public function userWithIdExist(int $id): void
    {
        /** @var UserCreator $creator */
        $creator = app()->make(UserCreator::class);
        $creator->createOrReplaceUserById($id);
    }

    /**
     * @Given user with id :id not exist
     * @param int $id
     * @throws BindingResolutionException
     */
    public function userWithIdNotExist(int $id): void
    {
        /** @var UserCreator $creator */
        $creator = app()->make(UserCreator::class);
        $creator->removeUserByIdIfExists($id);
    }
}
