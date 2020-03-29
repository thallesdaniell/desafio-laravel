<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    use SoftDeletes;

    protected $fillable =[
        'phone'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class);
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
