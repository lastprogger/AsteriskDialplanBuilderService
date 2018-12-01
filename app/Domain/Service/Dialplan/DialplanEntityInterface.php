<?php


namespace App\Domain\Service\Dialplan;


interface DialplanEntityInterface
{
    /**
     * @return string
     */
    public function __toString();

    /**
     * @return string
     */
    public function getName(): string;
}
