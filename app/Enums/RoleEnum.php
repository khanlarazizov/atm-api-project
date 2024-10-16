<?php

namespace App\Enums;

enum RoleEnum: string
{
    case USER = 'user';
    case SPECIAL_USER = 'special-user';
    case ADMIN = 'admin';
}
