<?php

namespace App\Enums;

enum PermissionStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';

    public function labelMM(): string
    {
        return match ($this) {
            self::Active => 'အသုံးပြုနေသည်',
            self::Inactive => 'အသုံးမပြုတော့ပါ',
        };
    }
}