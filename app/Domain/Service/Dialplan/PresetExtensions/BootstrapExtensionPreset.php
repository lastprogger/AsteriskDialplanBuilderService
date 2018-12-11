<?php

namespace App\Domain\Service\Dialplan\PresetExtensions;

use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;

class BootstrapExtensionPreset extends Extension
{
    protected $name = '_X.';

    public function __construct()
    {
        parent::__construct($this->name);

        $dialplan = new Dialplan();

        $agi  = $dialplan->Agi(config('dialplan.agi_call_setup_command'));
        $lang = $dialplan->Set('LANGUAGE()=${LANG}');
        $auth = $dialplan->GoToIf('$[${AUTH}=1]', 'auth,auth,start');
        $goTo = $dialplan->GoToStatement('start', '${START_EXTEN}', 'incom');

        $this->addPriority($agi);
        $this->addPriority($lang);
        $this->addPriority($auth);
        $this->addPriority($goTo);
    }
}