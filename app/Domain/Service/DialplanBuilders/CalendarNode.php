<?php


namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\Option;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\ExtensionStorageService;

/**
 * Class CalendarNode
 *
 * @link http://asterisk.ru/knowledgebase/Asterisk%20cmd%20GotoIfTime
 */
class CalendarNode extends AbstractDialplanExtensionBuilder
{

    protected function doBuild(array $payload, BuildContext $buildContext): Extension
    {
        foreach ($payload['data'] as $schedule) {

            $goToIfPasses = [
                config('dialplan.default_context'),
                $this->getExtenIfPasses()->getName(),
                'start',
            ];

            $app = $this->dialplan->goToIfTime($schedule['time'], $schedule['weekDays'], null, null, $goToIfPasses);
            $this->exten->addPriority($app);
        }

        $this->exten->addPriority(
            $this->dialplan->GoToStatement(
                'start', $this->getExtenIfDeclined()->getName(), config('dialplan.default_context')
            )
        );

        return $this->exten;
    }
}
