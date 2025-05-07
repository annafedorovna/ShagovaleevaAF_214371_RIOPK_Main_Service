<?php
namespace App;

use App\API\AuthAPITrait;
use Illuminate\Foundation\Auth\User as Authed;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;
use Hash;

/**
 * Class User
 *
 * @package App
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
*/
class User extends Authed implements Authenticatable
{
    use Notifiable;
    use HasRoles;
    use AuthAPITrait;

    protected $fillable = ['name', 'email', 'password', 'remember_token'];


    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    /**
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->remember_token;
    }

    /**
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function isAllows($type)
    {
        $roles = self::fetchRoles($this);

        $permissionIds = DB::table('role_has_permissions')
            ->whereIn('role_id', $roles->pluck('id')->toArray())
            ->get()
            ->pluck('permission_id')
            ->toArray();

        return DB::table('permissions')
            ->whereIn('id', $permissionIds)
            ->where('name', $type)
            ->exists();
    }

    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input)
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
    
    
    public function role()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public static function fetchRoles($user)
    {
        return DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_id', $user->id)
            ->where('model_type',  'App\User')
            ->get();
    }

    public static function doSyncRoles(array $roles, $modelId)
    {
        DB::table('model_has_roles')
            ->where('model_id', $modelId)
            ->where('model_type',  'App\User')
            ->delete();

        foreach ($roles as $roleId) {
            self::doAssignRole($roleId, $modelId);
        }
    }

    public static function doAssignRole($roleId, $modelId)
    {
        DB::table('model_has_roles')->insert([
            'model_id' => $modelId,
            'role_id' => $roleId,
            'model_type' => 'App\User',
        ]);
    }
}
