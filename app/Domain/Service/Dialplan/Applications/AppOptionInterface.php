<?php

namespace App\Domain\Service\Dialplan\Applications;

interface AppOptionInterface
{
    /**
     * AppOptionInterface constructor.
     *
     * @param string $name
     * @param string|null $param
     */
    public function __construct(string $name, ?string $param = null);

    public function __toString();
}
