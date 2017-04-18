<?php

declare(strict_types = 1);

namespace Wbits\Kxb\Exception;

final class InvalidJson extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct('Invalid JSON: ' . $message, $code, $previous);
    }
}
