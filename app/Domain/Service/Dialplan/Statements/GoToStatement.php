<?php

namespace App\Domain\Service\Dialplan\Statements;

use App\Domain\Service\Dialplan\DialplanEntityInterface;
use App\Domain\Service\Dialplan\Extension;

class GoToStatement implements DialplanEntityInterface
{
    protected $name = 'GoTo';

    private $extension;
    private $priority;
    private $context;

    public function __construct(string $priority, ?string $extension = null, ?string $context = null)
    {
        $this->priority  = $priority;
        $this->extension = $extension;
        $this->context   = $context;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        return implode('|', array_filter([$this->context, $this->extension, $this->priority]));
    }
}
