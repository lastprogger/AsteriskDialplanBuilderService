<?php


namespace App\Domain\Service\DialplanBuilders;


use App\Domain\Models\Extension as ExtensionModel;
use App\Domain\Models\PbxScheme;
use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\DialplanBuilders\Exceptions\StoreDialplanException;
use Exception;
use Illuminate\Support\Facades\DB;
use Log;

class DialplanStoreService
{
    /**
     * @param string   $companyId
     * @param string   $pbxSchemeId
     * @param Dialplan $dialplan
     *
     * @throws StoreDialplanException
     */
    public function storeDialplan(string $companyId, string $pbxSchemeId, Dialplan $dialplan): void
    {
        try {
            DB::beginTransaction();

            foreach ($dialplan->getExtensions() as $extension) {
                $this->storeExtension('incom', $extension, $companyId, $pbxSchemeId);

                if ($extension->isStarter()) {
                    $pbxScheme = new PbxScheme();
                    $pbxScheme->pbx_scheme_id = $pbxSchemeId;
                    $pbxScheme->start_exten = $extension->getName();
                    $pbxScheme->save();
                }
            }

            DB::commit();
        } catch (StoreDialplanException $e) {
            DB::rollBack();
            Log::error($e);
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
}