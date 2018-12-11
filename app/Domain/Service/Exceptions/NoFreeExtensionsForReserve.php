<?php

namespace App\Domain\Service\Exceptions;

use Exception;

class NoFreeExtensionsForReserve extends Exception
{
    public function __construct()
    {
        $message = 'No free extensions for reserve! It is very important to generate new extensions right now!';

        parent::__construct(
            $message, 500
        );
    }
}