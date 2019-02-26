<?php


namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\Option;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\ExtensionStorageService;

class CalendarNode extends AbstractDialplanExtensionBuilder
{

    protected function doBuild(array $payload, BuildContext $buildContext): Extension
    {
        foreach ($payload as $schedule) {

            $goToIfPasses = [
                config('dialplan.default_context'),
                $this->getExtenIfPasses()->getName(),
                'start',
            ];

            $app = $this->dialplan->goToIfTime($schedule['time'], $schedule['weedDays'], null, null, $goToIfPasses);
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
