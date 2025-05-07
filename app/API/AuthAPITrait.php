<?php

namespace App\API;

use GuzzleHttp\Client;

trait AuthAPITrait
{
    private static function authRequest(string $method, string $path, array $params = [])
    {
        $client = new Client();
        $res = $client->request(
            $method,
            config('authservice.path') . $path,
            [
                'body' => \json_encode($params),
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Auth ' . config('authservice.secret'),
                ]
            ]
        );

        return \json_decode($res->getBody()->getContents(), true);
    }

    public static function login(string $email, string $password)
    {
        return self::authRequest('POST', '/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);
    }

    public static function fetchItem(int $id)
    {
        return self::authRequest('GET', '/auth/user/' . $id);
    }

    public static function fetchAll(int $page)
    {
        return self::authRequest('GET', '/auth/user', [
            'page' => $page,
        ]);
    }

    public static function storeItem(string $name, string $email, $password)
    {
        return self::authRequest('POST', '/auth/user',  [
            'name' => $name,
            'email' => $email,
            'password' => $password ?: '',
        ]);
    }

    public static function updateItem(int $id, string $name, string $email, $password)
    {
        return self::authRequest('PUT', '/auth/user/' . $id,  [
            'name' => $name,
            'email' => $email,
            'password' => $password ?: '',
        ]);
    }


    public static function deleteItem(int $id)
    {
        return self::authRequest('DELETE', '/auth/user/' . $id);
    }
}