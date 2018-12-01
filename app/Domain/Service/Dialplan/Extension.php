<?php

namespace App\Domain\Service\Dialplan;

class Extension
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array|Priority[]
     */
    private $priorities = [];

    /**
     * Extension constructor.
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Priority[]|array
     */
    public function getPriorities(): array
    {
        return $this->priorities;
    }

    /**
     * @param DialplanEntityInterface $dialplanEntity
     * @param null|string             $alias
     */
    public function addPriority(DialplanEntityInterface $dialplanEntity, ?string $alias = null)
    {
        $this->priorities[] = new Priority($this->getNextPriorityIndex(), $dialplanEntity, $alias);
    }

    /**
     * @return int
     */
    private function getNextPriorityIndex(): int
    {
        return count($this->priorities) + 1;
    }
}
