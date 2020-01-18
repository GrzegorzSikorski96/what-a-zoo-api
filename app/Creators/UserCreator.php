<?php

declare(strict_types=1);

namespace App\Creators;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserCreator
 * @package Sms\Creators
 */
class UserCreator
{
    /**
     * @param string $email
     * @param string $password
     * @return void
     */
    public function createOrReplaceUser(string $email, string $password): void
    {
        $user = User::withTrashed()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'testName',
                'surname' => 'testSurname',
                'password' => Hash::make($password),
                'deleted_at' => null,
                'blocked_at' => null,
            ]
        );

        $user->deleted_at = null;

        $user->save();
    }

    /**
     * @param int $id
     * @return void
     */
    public function createOrReplaceUserById(int $id): void
    {
        if (User::withTrashed()->find($id)) {
            $user = User::withTrashed()->updateOrCreate(
                ['id' => $id],
                [
                    'name' => 'testName',
                    'surname' => 'testSurname',
                    'password' => Hash::make('secret'),
                    'deleted_at' => null,
                    'blocked_at' => null,
                ]
            );
        } else {
            $user = User::withTrashed()->updateOrCreate(
                ['id' => $id],
                [
                    'name' => 'testName',
                    'email' => 'userwith' . $id . '@example.com',
                    'surname' => 'testSurname',
                    'password' => Hash::make('secret'),
                    'deleted_at' => null,
                    'blocked_at' => null,
                ]
            );
        }

        $user->save();
    }

    /**
     * @param string $email
     * @return void
     */
    public function removeUserIfExists(string $email): void
    {
        User::where('email', $email)->forceDelete();
    }

    /**
     * @param int $id
     * @return void
     */
    public function removeUserByIdIfExists(int $id): void
    {
        if (User::find($id)) {
            User::findOrFail($id)->forceDelete();
        }
    }
}
