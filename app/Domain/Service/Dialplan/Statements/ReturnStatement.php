<?php

namespace App\Domain\Service\Dialplan\Statements;

use App\Domain\Service\Dialplan\DialplanEntityInterface;

class ReturnStatement implements DialplanEntityInterface
{
    protected $name = 'Return';

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return 'Return';
    }
}