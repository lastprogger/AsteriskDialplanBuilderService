<?php

namespace App\Domain\Service\DialplanBuilders\Exceptions;

use Exception;

class RelationCannotBeEstablishedException extends Exception
{

    /**
     * RelationCannotBeEstablishedException constructor.
     */
    public function __construct(string $fromNodeId, string $toNodeId)
    {
        parent::__construct(
            'Relation from ' . $fromNodeId . ' to ' . $toNodeId . 'can not be established!'
        );
    }
}