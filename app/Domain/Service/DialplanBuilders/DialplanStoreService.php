<?php


namespace App\Domain\Service\DialplanBuilders;


use App\Domain\Models\Extension as ExtensionModel;
use App\Domain\Models\PbxScheme;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\DialplanBuilders\Exceptions\StoreDialplanException;
use App\Domain\Service\ExtensionStorageService;
use App\Domain\Service\SwitchPbxSchemeService;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;

class DialplanStoreService
{
    private $switchPbxSchemeService;
    private $extensionStorageService;

    public function __construct(
        SwitchPbxSchemeService $switchPbxSchemeService,
        ExtensionStorageService $extensionStorageService
    ) {
        $this->switchPbxSchemeService  = $switchPbxSchemeService;
        $this->extensionStorageService = $extensionStorageService;
    }

    /**
     * @param string   $companyId
     * @param string   $pbxId
     * @param string   $pbxSchemeId
     * @param Dialplan $dialplan
     *
     * @throws StoreDialplanException
     */
    public function storeDialplan(string $companyId, string $pbxId, string $pbxSchemeId, Dialplan $dialplan): void
    {
        try {
            DB::beginTransaction();
            $this->switchPbxSchemeService->deletePbx($pbxId);

            foreach ($dialplan->getExtensions() as $extension) {
                $this->storeExtension('incom', $extension, $companyId, $pbxSchemeId);

                if ($extension->isStarter()) {
                    $pbxScheme                = new PbxScheme();
                    $pbxScheme->pbx_id        = $pbxId;
                    $pbxScheme->company_id    = $companyId;
                    $pbxScheme->pbx_scheme_id = $pbxSchemeId;
                    $pbxScheme->start_exten   = $extension->getName();
                    $pbxScheme->save();
                }
            }

            DB::commit();
        } catch (StoreDialplanException $e) {
            DB::rollBack();
            Log::error($e);
            $this->rollbackExtensionsReserve($dialplan->getExtensions());
            throw new StoreDialplanException('Store dialplan error', 500, $e);
        }
    }

    /**
     * @param string    $context
     * @param Extension $extension
     * @param string    $companyId
     * @param string    $pbxSchemeId
     *
     * @throws StoreDialplanException
     */
    public function storeExtension(
        string $context,
        Extension $extension,
        ?string $companyId = null,
        ?string $pbxSchemeId = null
    ): void {
        try {
            foreach ($extension->getPriorities() as $prior) {
                $extensionModel                = new ExtensionModel();
                $extensionModel->context       = $context;
                $extensionModel->exten         = $extension->getName();
                $extensionModel->priority      = $prior->toString();
                $extensionModel->app           = $prior->getDialplanEntity()->getName();
                $extensionModel->appdata       = $prior->getDialplanEntity()->__toString();
                $extensionModel->company_id    = $companyId;
                $extensionModel->pbx_scheme_id = $pbxSchemeId;
                $extensionModel->save();
            }
        } catch (Exception $e) {
            throw new StoreDialplanException('Store extension error', 500, $e);
        }
    }

    /**
     * @param Extension[] $extensions
     */
    private function rollbackExtensionsReserve(array $extensions): void
    {
        collect($extensions)->each(
            function (Extension $extension) {
                $this->extensionStorageService->releaseReserve($extension->getName());
            }
        );
    }
}