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
        $user = User::withTrashed()->firstOrCreate(
            ['email' => $email],
            [
                'name' => 'testName',
                'password' => Hash::make($password),
            ]
        );

        $user->deleted_at = null;

        $user->save();
    }

    /**
     * @param string $email
     * @return void
     */
    public function removeUserIfExists(string $email): void
    {
        User::where('email', $email)->delete();
    }
}
