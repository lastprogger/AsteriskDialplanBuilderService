<?php


namespace App\Domain\Service\Dialplan\Applications;


class Option implements AppOptionInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var null|string
     */
    protected $param;

    /**
     * Option constructor.
     *
     * @param $name
     * @param $param
     */
    public function __construct(string $name, ?string $param = null)
    {
        $this->name  = $name;
        $this->param = $param;
    }


    public function __toString()
    {
        $optionStr = $this->name;

        if ($this->param !== null) {
            $optionStr .= '(' . $this->param . ')';
        }

        return $optionStr;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Option
     */
    public function setName(string $name): self
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getParam(): ?string
    {
        return $this->param;
    }

    /**
     * @param string $param
     *
     * @return Option
     */
    public function setParam(string $param): self
    {
        $this->param = $param;
    }
}
