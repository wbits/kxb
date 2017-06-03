<?php

declare(strict_types=1);

namespace Wbits\Kxb\Gallery\Infrastructure;

use Wbits\Kxb\Exception\InvalidJson;

final class JsonDecoder
{
    public static function decode($json): array
    {
        $result = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $message = json_last_error_msg();
            throw new InvalidJson($message);
        }

        return $result;
    }
}

