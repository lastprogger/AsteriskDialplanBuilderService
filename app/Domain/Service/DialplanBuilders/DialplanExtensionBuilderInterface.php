<?php

namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\ExtensionStorageService;

interface DialplanExtensionBuilderInterface
{
    /**
     * DialplanExtensionBuilderInterface constructor.
     *
     * @param ExtensionStorageService $extensionStorageService
     * @param Dialplan                $dialplan
     * @param BuildContext            $buildContext
     */
    public function __construct(ExtensionStorageService $extensionStorageService, Dialplan $dialplan, BuildContext $buildContext);

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
     * @param array        $payload
     *
     * @return Extension
     */
    public function build(array $payload): Extension;
}
