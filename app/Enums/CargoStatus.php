<?php

namespace App\Enums;

enum CargoStatus: string
{
    case Registered = 'registered';
    case Delivered  = 'delivered';
    case Taken      = 'taken';
    case Lost       = 'lost';
    case Deleted    = 'deleted';

    public function labelMM(): string
    {
        return match ($this) {
            self::Registered => 'စာရင်းသွင်းပြီး',
            self::Delivered  => 'ပို့ပြီး',
            self::Taken      => 'ရွေးပြီး',
            self::Lost       => 'ပျောက်ဆုံး',
            self::Deleted    => 'ပယ်ဖျက်ပြီး',
        };
    }
}
