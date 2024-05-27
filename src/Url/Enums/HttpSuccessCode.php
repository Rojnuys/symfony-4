<?php

namespace App\Url\Enums;

enum HttpSuccessCode: int
{
    case OK = 200;
    case CREATED = 201;
    case MOVED_PERMANENTLY = 301;
    case FOUND = 302;
}
