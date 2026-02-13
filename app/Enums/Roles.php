<?php

namespace App\Enums;

enum Roles: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function toMiddleware(): string
    {
        return 'role:' . $this->value;
    }
}