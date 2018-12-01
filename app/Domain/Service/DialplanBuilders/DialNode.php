<?php


namespace App\Domain\Service\DialplanBuilders;


use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\Option;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;

class DialNode extends AbstractDialplanExtensionBuilder
{
    private $endpoint;
    private $limit;
    private $musicOnHold;
    private $needRecord;

    public function __construct(Dialplan $dialplan, array $data)
    {
        parent::__construct($dialplan, $data);

        $appData           = $data['data'];
        $this->endpoint    = $appData['endpoint'];
        $this->limit       = $appData['limit'] ?? null;
        $this->musicOnHold = $appData['music_on_hold'] ?? null;
        $this->needRecord  = $appData['need_record'] ?? true;
    }

    protected function doBuild(): Extension
    {
        if ($this->needRecord === false) {
            $stopMixMonitorApp = $this->dialplan->StopMixMonitor();
            $this->exten->addPriority($stopMixMonitorApp);
        }

        $dialApp = $this->dialplan->Dial(
            'SIP/' . $this->endpoint,
            [
                new Option(Dial::OPT_DISALLOW_REDIRECT),
                new Option(Dial::OPT_ALLOW_TRANSFER),
            ]
        );

        if ($this->musicOnHold !== null) {
            $dialApp->setOption(new Option(Dial::OPT_MUSIC_ON_HOLD, $this->musicOnHold));
        }

        $this->exten->addPriority($dialApp);

        return $this->exten;
    }
}
