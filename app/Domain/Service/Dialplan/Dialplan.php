<?php


namespace App\Domain\Service\Dialplan;


use App\Domain\Service\Dialplan\Applications\Agi;
use App\Domain\Service\Dialplan\Applications\AppOptionInterface;
use App\Domain\Service\Dialplan\Applications\Authenticate;
use App\Domain\Service\Dialplan\Applications\Curl;
use App\Domain\Service\Dialplan\Applications\Dial;
use App\Domain\Service\Dialplan\Applications\MixMonitor;
use App\Domain\Service\Dialplan\Applications\NoOp;
use App\Domain\Service\Dialplan\Applications\Playback;
use App\Domain\Service\Dialplan\Applications\Set;
use App\Domain\Service\Dialplan\Applications\StopMixMonitor;
use App\Domain\Service\Dialplan\Statements\GoToIf;
use App\Domain\Service\Dialplan\Statements\GoToIfTime;
use App\Domain\Service\Dialplan\Statements\GoToStatement;
use App\Domain\Service\Dialplan\Statements\ReturnStatement;

class Dialplan
{
    private $extensions   = [];


    public function createExtension(string $name = ''): Extension
    {
        $extension = new Extension($name?:uniqid());
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

    public function GoToStatement(string $priority, ?string $exten = null, ?string $context = null): Statements\GoToStatement
    {
        return new GoToStatement($priority, $exten, $context);
    }

    public function Curl(string $url, array $postData = []): Applications\Curl
    {
        return new Curl($url, $postData);
    }

    public function Agi(string $command, array $args = []): Applications\Agi
    {
        return new Agi($command, $args);
    }

    public function Set(string $data): Applications\Set
    {
        return new Set($data);
    }

    public function GoToIf(string $condition, ?string $labelTrue = '', ?string $labelFalse = '')
    {
        return new GoToIf($condition, $labelTrue, $labelFalse);
    }

    public function Authenticate(string $password): Applications\Authenticate
    {
        return new Authenticate($password);
    }

    public function ReturnStatement(): Statements\ReturnStatement
    {
        return new ReturnStatement();
    }

    public function goToIfTime(
        ?string $timeInterval,
        ?string $weekDays,
        ?string $monthDays,
        ?string $month,
        array $goTo
    ): GoToIfTime {
        return new GoToIfTime($timeInterval, $weekDays, $monthDays, $month, $goTo);
    }
}
