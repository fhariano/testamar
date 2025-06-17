<?php

namespace App\Enum;

enum PermissionsEnum: string
{
    case ManageProducts = 'manage_products';
    case ManageUsers = 'manage_users';
}
