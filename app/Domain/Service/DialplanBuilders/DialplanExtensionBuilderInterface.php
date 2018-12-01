<?php

namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;

interface DialplanExtensionBuilderInterface
{
    /**
     * DialplanExtensionBuilderInterface constructor.
     *
     * @param Dialplan $dialplan
     * @param array    $data
     */
    public function __construct(Dialplan $dialplan, array $data);

    /**
     * @param Extension $extension
     * @param string    $relationType
     */
    public function addRelatedExtension(Extension $extension, string $relationType): void;

    /**
     * @return Extension
     */
    public function getExtension(): Extension;

    /**
     * @return Extension
     */
    public function build(): Extension;
}
