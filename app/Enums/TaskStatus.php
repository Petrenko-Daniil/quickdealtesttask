<?php

namespace App\Enums;

enum TaskStatus: int
{
    case Created = 1;
    case Accepted = 2;
    case Finished = 3;


    public function getStatusName(): string
    {
        return match ($this){
            self::Created => 'Created',
            self::Accepted => 'Accepted',
            self::Finished => 'Finished'
        };
    }
}
