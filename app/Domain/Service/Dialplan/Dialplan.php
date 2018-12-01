<?php


namespace App\Domain\Service\Dialplan;


use App\Domain\Service\Dialplan\Applications\AppOptionInterface;
use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\MixMonitor;
use App\Domain\Service\Dialplan\Applications\NoOp;
use App\Domain\Service\Dialplan\Applications\Playback;
use App\Domain\Service\Dialplan\Applications\StopMixMonitor;
use App\Domain\Service\Dialplan\Statements\GoToStatement;

class Dialplan
{
    private $dialplanData = [];
    private $extensions   = [];


    public function createExtension(): Extension
    {
        $extension = new Extension(uniqid());
        $this->extensions[] = $extension;
        return $extension;
    }

    /**
     * @return array|Extension[]
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * @param string                     $endpoint
     * @param array|AppOptionInterface[] $options
     *
     * @return Dial
     */
    public function Dial(string $endpoint, array $options): Applications\Dial
    {
        return new Dial($endpoint, $options);
    }

    public function MixMonitor(): Applications\MixMonitor
    {
        return new MixMonitor(md5(mktime()));
    }

    public function StopMixMonitor(): Applications\StopMixMonitor
    {
        return new StopMixMonitor();
    }

    public function Playback(string $filename): Applications\Playback
    {
        return new Playback($filename);
    }

    public function NoOp(string $text): Applications\NoOp
    {
        return new NoOp($text);
    }

    public function GoToStatement(string $exten, string $priority): Statements\GoToStatement
    {
        return new GoToStatement($exten, $priority);
    }
}
