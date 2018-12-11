<?php


namespace App\Domain\Service;


class SwitchPbxSchemeService
{
    private $extensionsStorage;

    public function __construct(ExtensionStorageService $extensionStorageService)
    {
        $this->extensionsStorage = $extensionStorageService;
    }

    public function switchPbxScheme(): void
    {

    }
}