<?php

namespace App\Domain\Service\Dialplan;

class Priority
{
    /**
     * @var string
     */
    protected $index;
    /**
     * @var DialplanEntityInterface
     */
    protected $dialplanEntity;
    /**
     * @var string|null
     */
    protected $alias;

    /**
     * Priority constructor.
     *
     * @param string                  $index
     * @param DialplanEntityInterface $dialplanEntity
     * @param null|string             $alias
     */
    public function __construct(string $index, DialplanEntityInterface $dialplanEntity, ?string $alias = null)
    {
        $this->index          = $index;
        $this->dialplanEntity = $dialplanEntity;
        $this->alias          = $alias;
    }

    /**
     * @return string
     */
    public function getIndex(): string
    {
        return $this->index;
    }

    /**
     * @return DialplanEntityInterface
     */
    public function getDialplanEntity(): DialplanEntityInterface
    {
        return $this->dialplanEntity;
    }

    /**
     * @return string|null
     */
    public function getAlias(): ?string
    {
        return $this->alias;
    }
}
