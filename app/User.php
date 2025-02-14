<?php

namespace App;

use Encore\Admin\Auth\Database\HasPermissions;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable, AdminBuilder, HasPermissions;

    const ADMIN = 0;
    const CUSTOMER = 1;
    const ACTIVE = 1;
    const DEACTIVE = 0;
    protected $table = "admin_users";
    protected $fillable = '*';
    protected $casts = [
        'created_at' => 'datetime:H:i | d-m-Y'
    ];

    public function __construct(array $attributes = [])
    {
        $connection = $this->connection ?: config('database.default');
        $this->setConnection($connection);
        $this->setTable(config('admin.database.users_table'));
        parent::__construct($attributes);
    }

    public function getAvatarAttribute($avatar)
    {
        if (url()->isValidUrl($avatar)) {
            return $avatar;
        }
        $disk = config('admin.upload.disk');
        if ($avatar && array_key_exists($disk, config('filesystems.disks'))) {
            return Storage::disk(config('admin.upload.disk'))->url($avatar);
        }
        $default = config('admin.default_avatar') ?: '/bamboo-admin/AdminLTE/dist/img/user2-160x160.jpg';
        return admin_asset($default);
    }

    public function roles(): BelongsToMany
    {
        $pivotTable = config('admin.database.role_users_table');
        $relatedModel = config('admin.database.roles_model');
        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id');
    }

    public function permissions(): BelongsToMany
    {
        $pivotTable = config('admin.database.user_permissions_table');
        $relatedModel = config('admin.database.permissions_model');
        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'permission_id');
    }

    public function getAccessToken()
    {
        $token = json_decode($this->token, true);
        if ($token && isset($token['access_token'])) {
            return $token['access_token'];
        }
        return '';
    }
}
