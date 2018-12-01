<?php

namespace App\Domain\Service\DialplanBuilders\Factories;

use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\DialplanBuilders\DialNode;
use App\Domain\Service\DialplanBuilders\DialplanExtensionBuilderInterface;
use App\Domain\Service\DialplanBuilders\Factories\Exceptions\UndefinedExtensionBuilderException;
use App\Domain\Service\DialplanBuilders\PlaybackNode;

class DialplanExtensionBuilderFactory
{
    private static $classMap = [
        'dial'     => DialNode::class,
        'playback' => PlaybackNode::class,
    ];

    /**
     * @param Dialplan $dialplan
     * @param array    $data
     *
     * @return DialplanExtensionBuilderInterface
     * @throws UndefinedExtensionBuilderException
     */
    static public function make(Dialplan $dialplan, array $data): DialplanExtensionBuilderInterface
    {
        $className = self::getClassName($data['node_type']['name']);

        return new $className($dialplan, $data);
    }

    /**
     * @param Dialplan $dialplan
     * @param array    $data
     *
     * @return array
     * @throws UndefinedExtensionBuilderException
     */
    static public function makeMany(Dialplan $dialplan, array $data): array
    {
        $extensionBuilders = [];

        foreach ($data as $nodeData) {
            $extensionBuilders[] = self::make($dialplan, $nodeData);
        }
    }

    /**
     * @param string $name
     *
     * @return string
     * @throws UndefinedExtensionBuilderException
     */
    static private function getClassName(string $name): string
    {
        $name = strtolower($name);

        if (isset(self::$classMap[$name])) {
            return self::$classMap[$name];
        }

        throw new UndefinedExtensionBuilderException('Extension builder for node "' . $name . '" not exist');
    }
}
