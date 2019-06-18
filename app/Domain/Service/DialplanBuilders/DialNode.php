<?php


namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Models\SipUser;
use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\Option;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\DialplanBuilders\Exceptions\DialplanBuildException;
use App\Domain\Service\ExtensionStorageService;

class DialNode extends AbstractDialplanExtensionBuilder
{

    protected function doBuild(array $payload, BuildContext $buildContext): Extension
    {
        $appData       = $payload['data'];
        $endpoint      = $appData['endpoint'];
        $phoneNumberId = $appData['phone_number_id'];
        $limit         = $appData['limit'] ?? null;
        $musicOnHold   = $appData['music_on_hold'] ?? null;
        $needRecord    = $appData['need_record'] ?? true;
        $type          = $appData['type'];

        if ($type === 'sip') {
            /** @var SipUser $sipUser */
            $sipUser = SipUser::query()->where('phone_number_id', $phoneNumberId)->first();

            if ($sipUser === null) {
                throw new DialplanBuildException(
                    'Endpoint ' . $endpoint . ' not exist'
                );
            }
            $endpoint = $sipUser->username;
        } else {
            $endpoint = $endpoint . '@' . config('trunk.default_trunk');
        }

        if ($needRecord === false) {
            $stopMixMonitorApp = $this->dialplan->StopMixMonitor();
            $this->exten->addPriority($stopMixMonitorApp);
        }

        $dialApp = $this->dialplan->Dial(
            'SIP/' . $endpoint,
            [
                new Option(Dial::OPT_DISALLOW_REDIRECT),
                new Option(Dial::OPT_ALLOW_TRANSFER),
            ]
        );

        if ($musicOnHold !== null) {
            $dialApp->setOption(new Option(Dial::OPT_MUSIC_ON_HOLD, $musicOnHold));
        }

        $this->exten->addPriority($dialApp);

        return $this->exten;
    }

    private function makeDialString(string $endpoint, string $type)
    {

    }
}
