<?php

namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\DialplanBuilders\Exceptions\DialplanBuildException;
use App\Domain\Service\DialplanBuilders\Exceptions\RelationCannotBeEstablishedException;
use App\Domain\Service\DialplanBuilders\Factories\DialplanExtensionBuilderFactory;
use App\Domain\Service\ExtensionStorageService;
use Exception;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use SplQueue;

class DialplanBuilder
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var Dialplan
     */
    private $dialplan;
    /**
     * @var ExtensionRelationsResolver
     */
    private $relationsResolver;
    /**
     * @var ExtensionStorageService
     */
    private $extensionsStorage;
    /**
     * @var BuildContext $buildContext
     */
    private $buildContext;

    /**
     * DialplanBuilder constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->dialplan          = new Dialplan();
        $this->relationsResolver = new ExtensionRelationsResolver($data['node_relations']);
        $this->extensionsStorage = new ExtensionStorageService();
        $this->buildContext      = new BuildContext($data['company_id'], $data['pbx_scheme_id'], $data['pbx_id']);
        $this->data              = $data;
    }

    /**
     * @return Dialplan
     * @throws DialplanBuildException
     */
    public function build(): Dialplan
    {
        try {
            /** @var DialplanExtensionBuilderInterface[] $extenBuilders */
            $extenBuilders = [];

            foreach ($this->data['nodes'] as $nodeData) {
                $extenBuilders[$nodeData['id']] = $this->makeExtensionBuilder($nodeData);
            }

            $this->relationsResolver->resolveAllRelations($extenBuilders);

            foreach ($extenBuilders as $nodeId => $extenBuilder) {
                $data = collect($this->data['nodes'])->where('id', $nodeId)->first();
                $extenBuilder->build($data);
            }

            return $this->dialplan;

        } catch (Exception $e) {
            Log::error(
                $e->getMessage(), [
                'exception' => $e,
            ]
            );
            $this->rollbackExtensionsReserve($extenBuilders);
            throw new DialplanBuildException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param array $data
     *
     * @return DialplanExtensionBuilderInterface
     * @throws Factories\Exceptions\UndefinedExtensionBuilderException
     */
    private function makeExtensionBuilder(array $data): DialplanExtensionBuilderInterface
    {
        return DialplanExtensionBuilderFactory::make($this->dialplan, $data, $this->buildContext);
    }

    /**
     * @param DialplanExtensionBuilderInterface[] $builders
     */
    private function rollbackExtensionsReserve(array $builders): void
    {
        collect($builders)->each(
            function (DialplanExtensionBuilderInterface $extensionBuilder) {
                $this->extensionsStorage->releaseReserve($extensionBuilder->getExtension()->getName());
            }
        );
    }
}