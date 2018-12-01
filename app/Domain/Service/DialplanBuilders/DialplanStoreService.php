<?php


namespace App\Domain\Service\DialplanBuilders;


use App\Domain\Models\Extension;
use App\Domain\Service\Dialplan\Dialplan;

class DialplanStoreService
{
    /**
     * @param string   $companyId
     * @param string   $pbxSchemeId
     * @param Dialplan $dialplan
     */
    public function storeDialplan(string $companyId, string $pbxSchemeId, Dialplan $dialplan): void
    {
        foreach ($dialplan->getExtensions() as $extension) {

            $context       = 'incom';
            $extensionName = $extension->getName();

            foreach ($extension->getPriorities() as $prior) {
                $extensionModel                = new Extension();
                $extensionModel->context       = $context;
                $extensionModel->exten         = $extensionName;
                $extensionModel->priority      = $prior->getAlias() === null ? $prior->getIndex()
                    : $prior->getIndex() . '(' . $prior->getAlias() . ')';
                $extensionModel->app           = $prior->getDialplanEntity()->getName();
                $extensionModel->appdata       = $prior->getDialplanEntity()->__toString();
                $extensionModel->company_id    = $companyId;
                $extensionModel->pbx_scheme_id = $pbxSchemeId;
                $extensionModel->save();
            }
        }
    }
}