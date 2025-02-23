<?php

namespace App\Enums;

enum Status: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;
}
