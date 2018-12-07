<?php

namespace App\Domain\Service\Dialplan\PresetExtensions;

use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;

class AuthExtensionPreset extends Extension
{
    protected $name = 'auth';

    public function __construct()
    {
        parent::__construct($this->name);

        $dialplan = new Dialplan();


        $auth   = $dialplan->Authenticate('${AUTH_PASS}');
        $return = $dialplan->ReturnStatement();


        $this->addPriority($auth);
        $this->addPriority($return);
    }
}