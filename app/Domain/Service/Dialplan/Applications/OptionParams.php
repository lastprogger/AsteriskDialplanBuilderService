<?php


namespace App\Domain\Service\Dialplan\Applications;


class OptionParams
{
    public $params;

    /**
     * OptionParams constructor.
     *
     * @param array|string[] $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function __toString()
    {
        return implode('^', array_filter($this->params));
    }
}
