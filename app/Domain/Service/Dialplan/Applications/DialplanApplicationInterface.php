<?php


namespace App\Domain\Service\Dialplan\Applications;


use App\Domain\Service\Dialplan\DialplanEntityInterface;

/**
 * Interface DialplanApplicationInterface
 *
 * @package App\Domain\Service\Dialplan\Applications
 */
interface DialplanApplicationInterface extends DialplanEntityInterface
{
    /**
     * @param array|AppOptionInterface[] $options
     *
     * @return DialplanApplicationInterface
     */
    public function setOptions(array $options): self;

    /**
     * @param Option $option
     *
     * @return DialplanApplicationInterface
     */
    public function setOption(AppOptionInterface $option): self;

    /**
     * @param string $data
     *
     * @return DialplanApplicationInterface
     */
    public function setAppData(string $data): self;
}
