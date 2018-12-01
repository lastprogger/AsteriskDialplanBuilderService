<?php

namespace App\Domain\Service\Dialplan\Statements;

use App\Domain\Service\Dialplan\DialplanEntityInterface;
use App\Domain\Service\Dialplan\Extension;

class GoToStatement implements DialplanEntityInterface
{
    protected $name = 'GoTo';

    private $extension;
    private $priority;

    public function __construct(string $extension, string $priority)
    {
        $this->extension = $extension;
        $this->priority  = $priority;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return implode('|', [$this->extension, $this->priority]);
    }
}
