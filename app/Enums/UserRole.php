<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case Subscriber = 'subscriber';
    case Editor = 'editor';
    case Admin = 'admin';
}
