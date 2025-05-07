<?php

namespace Tests\Unit;

use App\API\AuthAPITrait;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use AuthAPITrait;

    public function testLogin()
    {
        $user = (object)$this->login('admin@admin.com', 'password');;
        
        $this->assertEquals($user->user[0]['id'], 1);
    }

    public function testLoginAdmin()
    {
        $user = (object)$this->login('admin@admin.com', 'password');

        $permission = DB::table('model_has_roles')
            ->leftJoin('role_has_permissions', 'model_has_roles.role_id', '=', 'role_has_permissions.role_id')
            ->leftJoin('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('model_has_roles.model_id', '=', $user->user[0]['id'])
            ->pluck('name')[0];

        $this->assertEquals($permission, 'users_manage');
    }

    public function testFetchUsers()
    {
        $users = ($this->fetchAll(0)['data']);;

        $this->assertNotEquals(count($users), 0);
    }

    public function testFetchUser()
    {
        $user = $this->fetchItem(1);;

        $this->assertEquals($user['id'], 1);
    }
}
