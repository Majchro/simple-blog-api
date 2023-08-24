<?php

declare(strict_types=1);

namespace App\Enums;

enum ApiResponseStatus: string
{
    case Success = 'success';
    case Error = 'error';
}
