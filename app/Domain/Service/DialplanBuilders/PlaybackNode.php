<?php


namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\Option;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\ExtensionStorageService;

class PlaybackNode extends AbstractDialplanExtensionBuilder
{

    public function doBuild(array $payload, BuildContext $buildContext): Extension
    {
        $this->exten->addPriority($this->dialplan->Playback($payload['data']['filename']));

        return $this->exten;
    }
}
