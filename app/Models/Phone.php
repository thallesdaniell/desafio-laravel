<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Phone extends Model
{
    use SoftDeletes,LogsActivity;

    protected $fillable =[
        'phone'
    ];

    protected static $logAttributes = [
        'phone'
    ];

    protected static $submitEmptyLogs = false;

    public function getDescriptionForEvent(string $eventName): string
    {
        if ($eventName == 'created')
            return 'Telefone "' . $this->phone . '" foi criado';

        if ($eventName == 'updated')
            return 'Telefone "' . $this->phone . '" foi atualizado';

        if ($eventName == 'deleted')
            return 'Telefone "' . $this->phone . '" foi deletado';

        return '';
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_replace(['(',')','-'],[''],$value);
    }

    public function getPhoneAttribute($value)
    {
        return $this->mask('(##) #####-####',$value);
    }

    private function mask($mask, $value)
    {
        $lengthMask   = substr_count($mask, '#');
        $lengthString = strlen($value);
        if ($lengthMask == $lengthString) {
            $value = str_replace(' ', '', $value);
            for ($i = 0; $i < $lengthString; $i++)
                $mask[strpos($mask, '#')] = $value[$i];
            return $mask;
        }
        return $value;
    }


}
