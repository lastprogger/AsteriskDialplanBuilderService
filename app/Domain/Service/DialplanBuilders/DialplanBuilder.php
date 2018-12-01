<?php

namespace App\Domain\Service\DialplanBuilders;

use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\DialplanBuilders\Factories\DialplanExtensionBuilderFactory;
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
     * DialplanBuilder constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->dialplan          = new Dialplan();
        $this->relationsResolver = new ExtensionRelationsResolver($data['node_relations']);
        $this->data              = $data;
    }

    /**
     * @return Dialplan
     * @throws Exceptions\RelationCannotBeEstablishedException
     * @throws Factories\Exceptions\UndefinedExtensionBuilderException
     */
    public function build(): Dialplan
    {
        $extenBuilders = [];

        foreach ($this->data['nodes'] as $nodeData) {
            $extenBuilders[$nodeData['id']] = $this->makeExtensionBuilder($nodeData);
        }

        $this->relationsResolver->resolveAllRelations($extenBuilders);

        foreach ($extenBuilders as $extenBuilder) {
            $extenBuilder->build();
        }

        return $this->dialplan;
    }

    /**
     * @param array $data
     *
     * @return DialplanExtensionBuilderInterface
     * @throws Factories\Exceptions\UndefinedExtensionBuilderException
     */
    private function makeExtensionBuilder(array $data): DialplanExtensionBuilderInterface
    {
        return DialplanExtensionBuilderFactory::make($this->dialplan, $data);
    }

}