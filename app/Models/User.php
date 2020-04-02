<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
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

    public function guest()
    {
        return $this->hasMany(Guest::class);
    }

    public function from_guest()
    {
        return $this->hasOne(Guest::class, 'guest_id');
    }

    public static function log($guests)
    {
        return DB::table('activity_log')
            ->where(function (Builder $query) use ($guests) {
                $query->where('causer_type', 'User')->whereIn('causer_id', $guests);
            })
            ->orWhere(function (Builder $query) use ($guests) {
                $query->where('subject_type', 'User')->whereIn('subject_id', $guests);
            })->get();
    }
}
