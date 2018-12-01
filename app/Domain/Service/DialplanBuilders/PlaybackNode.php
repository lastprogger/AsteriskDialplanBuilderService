<?php


namespace App\Domain\Service\DialplanBuilders;


use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\Option;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;

class PlaybackNode extends AbstractDialplanExtensionBuilder
{
    private $filename;

    public function __construct(Dialplan $dialplan, array $data)
    {
        parent::__construct($dialplan, $data);

        $this->filename = $data['data']['filename'];
    }

    public function doBuild(): Extension
    {
        $this->exten->addPriority($this->dialplan->Playback($this->filename));

        return $this->exten;
    }
}
