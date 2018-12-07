<?php

namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Service\Dialplan\Extension;
use App\Domain\Service\DialplanBuilders\Exceptions\RelationCannotBeEstablishedException;
use Illuminate\Support\Collection;

class ExtensionRelationsResolver
{
    /**
     * @var Collection
     */
    private $mapRelations;
    /**
     * @var Collection|DialplanExtensionBuilderInterface[]
     */
    private $buildersCollection;

    public function __construct(array $mapRelations)
    {
        $this->mapRelations = collect($mapRelations);
    }

    /**
     * @param array $extenBuilders
     *
     * @throws RelationCannotBeEstablishedException
     */
    public function resolveAllRelations(array $extenBuilders): void
    {
        $this->buildersCollection = collect($extenBuilders);

        foreach ($extenBuilders as $nodeId => $builder) {
            $this->resolveRelations($nodeId, $builder);
        }
    }

    /**
     * @param string                            $nodeId
     * @param DialplanExtensionBuilderInterface $extensionBuilder
     *
     * @throws RelationCannotBeEstablishedException
     */
    private function resolveRelations(string $nodeId, DialplanExtensionBuilderInterface $extensionBuilder): void
    {
        $relations = $this->getRelations($nodeId);

        if (empty($relations)) {
            return;
        }

        foreach ($relations as $relation) {

            $toNodeId = $relation['to_node_id'];
            $type     = $relation['type'];

            if (!$this->buildersCollection->has($toNodeId)) {
                throw new RelationCannotBeEstablishedException($nodeId, $toNodeId);
            }
            /** @var DialplanExtensionBuilderInterface $relatedBuilder */
            $relatedBuilder = $this->buildersCollection->get($toNodeId);
            $extensionBuilder->addRelatedExtension($relatedBuilder->getExtension(), $type);
            $extensionBuilder->getExtension()->setIsStarter($this->isStarterExtension($nodeId));
        }
    }

    private function getRelations(string $nodeId): array
    {
        return $this->mapRelations->whereIn('from_node_id', $nodeId)->all();
    }

    private function isStarterExtension(string $nodeId): bool
    {
        return $this->mapRelations->where('to_node_id', $nodeId)->first() === null;
    }
}