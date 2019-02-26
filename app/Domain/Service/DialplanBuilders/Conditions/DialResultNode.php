<?php

namespace App\Domain\Service\DialplanBuilders\Conditions;

use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\Option;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\DialplanBuilders\AbstractDialplanExtensionBuilder;
use App\Domain\Service\DialplanBuilders\BuildContext;
use App\Domain\Service\ExtensionStorageService;

class DialResultNode extends AbstractDialplanExtensionBuilder
{

    protected function doBuild(array $payload, BuildContext $buildContext): Extension
    {

        $goToIf = $this->dialplan->GoToIf
        (
            '$[${DIALSTATUS}] = "ANSWER"',
            implode(',', ['start', $this->getExtenIfPasses()->getName(), config('dialplan.default_context')]),
            implode(',', ['start', $this->getExtenIfDeclined()->getName(), config('dialplan.default_context')])
        );

        $this->exten->addPriority($goToIf);

        return $this->exten;
    }
}
