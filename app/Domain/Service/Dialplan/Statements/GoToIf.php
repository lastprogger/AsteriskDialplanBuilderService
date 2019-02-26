<?php

namespace App\Domain\Service\Dialplan\Statements;

use App\Domain\Service\Dialplan\DialplanEntityInterface;
use App\Domain\Service\Dialplan\Extension;

/**
 * Class GoToIf
 *
 * @@link http://asterisk.ru/knowledgebase/Asterisk%20cmd%20GotoIf
 */
class GoToIf implements DialplanEntityInterface
{
    protected $name = 'GotoIf';

    private $condition;
    private $labelTrue;
    private $labelFalse;

    public function __construct(string $condition, string $labelTrue = '', string $labelFalse = '')
    {
        $this->condition  = $condition;
        $this->labelFalse = $labelTrue;
        $this->labelTrue  = $labelFalse;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        $appData = $this->condition . '?' . $this->labelTrue;

        if ($this->labelFalse) {
            $appData .= ':' . $this->labelFalse;
        }

        return $appData;
    }
}
