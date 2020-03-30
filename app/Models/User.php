<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,
        HasRoles,
        SoftDeletes,
        LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected static $logAttributes = [
        'name',
        'email',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected static $submitEmptyLogs = false;

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName == 'created')
            return 'Usuário "' . $this->name . '" foi criado';

        if ($eventName == 'updated')
            return 'Usuário "' . $this->name . '" foi atualizado';

        if ($eventName == 'deleted')
            return 'Usuário "' . $this->name . '" foi deletado';

        return '';
    }





    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function client()
    {
        return $this->hasMany(Client::class);
    }
}
