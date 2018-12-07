<?php


namespace Tests\Feature\Service\ExtensionPresets;


use App\Domain\Models\Extension;
use App\Domain\Service\Dialplan\PresetExtensions\AuthExtensionPreset;
use App\Domain\Service\Dialplan\PresetExtensions\BootstrapExtensionPreset;
use App\Domain\Service\DialplanBuilders\DialplanStoreService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AuthExtensionPresetTest extends TestCase
{
    use DatabaseTransactions;

    public function testStoreAuthExtensionPresetAssertSuccess()
    {
        $storeService = new DialplanStoreService();

        $storeService->storeExtension('auth', new AuthExtensionPreset());

        $res = Extension::query()->where('context', 'auth');

        $this->assertTrue($res->count() > 0);
    }
}