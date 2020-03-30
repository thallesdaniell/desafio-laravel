<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Model
{
    use SoftDeletes,LogsActivity;

    protected static $logAttributes = [
        'name',
        'email',
    ];

    protected static $submitEmptyLogs = false;


    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName == 'created')
            return 'Cliente "' . $this->name . '" foi criado';

        if ($eventName == 'updated')
            return 'Cliente "' . $this->name . '" foi atualizado';

        if ($eventName == 'deleted')
            return 'Cliente "' . $this->name . '" foi deletado';

        return '';
    }

    public function phone()
    {
        return $this->hasMany(Phone::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
