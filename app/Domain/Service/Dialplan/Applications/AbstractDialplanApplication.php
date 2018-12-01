<?php


namespace App\Domain\Service\Dialplan\Applications;


abstract class AbstractDialplanApplication implements DialplanApplicationInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var array|AppOptionInterface[]
     */
    protected $options = [];
    /**
     * @var string
     */
    protected $appData;

    /**
     * @var string
     */
    protected $command;

    public function __construct(?string $appData = null, ?array $options = [], ?string $command = null)
    {
        $this->appData = $appData;
        $this->options = $options;
        $this->command = $command;
    }


    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(array $options): DialplanApplicationInterface
    {
        $this->options = $options;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOption(AppOptionInterface $option): DialplanApplicationInterface
    {
        $this->options[] = $option;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppData(string $data): DialplanApplicationInterface
    {
        $this->appData = $data;
        return $this;
    }

    public function __toString()
    {
        $appDataToString = [
            $this->appData,
        ];

        if (count($this->options) > 0) {
            $appDataToString[] = implode('',$this->options);
        }

        if ($this->command !== null) {
            $appDataToString[] = $this->command;
        }

        return implode(',', $appDataToString);
    }
}
