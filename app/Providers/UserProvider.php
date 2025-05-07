<?php

namespace App\Providers;

use App\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\UserProvider as IlluminateUserProvider;

class UserProvider implements IlluminateUserProvider
{
    /**
     * @param  mixed  $identifier
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        $apiUser = (object)User::fetchItem($identifier);

        $user = new User();
        $user->id = $apiUser->id;
        $user->name = $apiUser->name;
        $user->email = $apiUser->email;
        $user->password = $apiUser->password ?? null;

        return $user;
    }

    /**
     * @param  mixed   $identifier
     * @param  string  $token
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token)
    {
        $apiUser = (object)User::fetchItem($identifier);

        $user = new User();
        $user->id = $apiUser->id;
        $user->name = $apiUser->name;
        $user->email = $apiUser->email;
        $user->password = $apiUser->password ?? null;

        return $user;
    }

    /**
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Save the given &quot;remember me&quot; token for the given user
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $apiUser = (object)(User::login($credentials['email'], $credentials['password'])['user']);

        $user = new User();
        $user->id = $apiUser->id;
        $user->name = $apiUser->name;
        $user->email = $apiUser->email;
        $user->password = $apiUser->password ?? null;

        return $user;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        try {
            $apiUser = (object)(User::login($credentials['email'], $credentials['password'])['user']);
            return !!$apiUser;
        } catch (\Exception $e) {
            return false;
        }
    }
}
