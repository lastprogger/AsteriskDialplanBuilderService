<?php

namespace App\Domain\Service\DialplanBuilders\Factories;

use App\Domain\Service\Dialplan\Dialplan;
use App\Domain\Service\DialplanBuilders\BuildContext;
use App\Domain\Service\DialplanBuilders\CalendarNode;
use App\Domain\Service\DialplanBuilders\Conditions\DialResultNode;
use App\Domain\Service\DialplanBuilders\DialNode;
use App\Domain\Service\DialplanBuilders\DialplanExtensionBuilderInterface;
use App\Domain\Service\DialplanBuilders\Factories\Exceptions\UndefinedExtensionBuilderException;
use App\Domain\Service\DialplanBuilders\PlaybackNode;
use App\Domain\Service\ExtensionStorageService;

class DialplanExtensionBuilderFactory
{
    private static $classMap = [
        'dial'     => DialNode::class,
        'playback' => PlaybackNode::class,
        'calendar' => CalendarNode::class,
        'dial_condition' => DialResultNode::class,
    ];

    private static $extensionStorageService;

    /**
     * @param Dialplan     $dialplan
     * @param array        $data
     * @param BuildContext $buildContext
     *
     * @return DialplanExtensionBuilderInterface
     * @throws UndefinedExtensionBuilderException
     */
    static public function make(
        Dialplan $dialplan,
        array $data,
        BuildContext $buildContext
    ): DialplanExtensionBuilderInterface
    {
        $className = self::getClassName($data['node_type']['name']);

        return new $className(self::getExtensionsStorage(), $dialplan, $buildContext);
    }

    /**
     * @param Dialplan $dialplan
     * @param array    $data
     *
     * @return array
     * @throws UndefinedExtensionBuilderException
     */
    static public function makeMany(Dialplan $dialplan, array $data, BuildContext $buildContext): array
    {
        $extensionBuilders = [];

        foreach ($data as $nodeData) {
            $extensionBuilders[] = self::make($dialplan, $nodeData, $buildContext);
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

    private static function getExtensionsStorage(): ExtensionStorageService
    {
        if (self::$extensionStorageService === null) {
            self::$extensionStorageService = new ExtensionStorageService();
        }

        return self::$extensionStorageService;
    }
}
