<?php

namespace Router;

enum AllowedMethods: string
{
    case POST = 'POST';
    case GET = 'GET';
    case UNSUPPORTED = 'UNSUPPORTED';
}
