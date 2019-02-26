<?php

namespace App\Domain\Service\Dialplan\Statements;

use App\Domain\Service\Dialplan\DialplanEntityInterface;
use App\Domain\Service\Dialplan\Extension;

/**
 * Class GoToIfTime
 *
 * @link http://asterisk.ru/knowledgebase/Asterisk%20cmd%20GotoIfTime
 */
class GoToIfTime implements DialplanEntityInterface
{
    private const DEFAULT_VALUE = '*';

    protected $name = 'GotoIfTime';

    private $timeInterval;
    private $weekDaysInterval;
    private $monthDaysInterval;
    private $month;
    private $goTo;

    /**
     * GoToIfTime constructor.
     *
     * @param string|null $timeInterval
     * @param string|null $weekDays
     * @param string|null $monthDays
     * @param string|null $month
     * @param array       $goTo must contains keys: context, extension, priority
     */
    public function __construct(
        ?string $timeInterval,
        ?string $weekDays,
        ?string $monthDays,
        ?string $month,
        array $goTo
    ) {
        $this->timeInterval      = $timeInterval ?? self::DEFAULT_VALUE;
        $this->weekDaysInterval  = $weekDays ?? self::DEFAULT_VALUE;
        $this->monthDaysInterval = $monthDays ?? self::DEFAULT_VALUE;
        $this->month             = $month ?? self::DEFAULT_VALUE;
        $this->goTo              = $goTo;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __toString()
    {
        $timeArg = implode('|', [$this->timeInterval, $this->weekDaysInterval, $this->monthDaysInterval, $this->month]);
        $goToArg = implode(',', $this->goTo);

        return $timeArg . '?' . $goToArg;
    }
}
