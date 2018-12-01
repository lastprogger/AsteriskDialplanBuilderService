<?php


namespace App\Domain\Service\Dialplan\Applications;


/**
 * Class Dial
 *
 * @link http://asterisk.ru/knowledgebase/Asterisk%20cmd%20Dial
 */
class Dial extends AbstractDialplanApplication
{
    const OPT_MUSIC_ON_HOLD     = 'm';
    const OPT_DISALLOW_REDIRECT = 'i';
    const OPT_ALLOW_TRANSFER    = 't';

    /**
     * @var string
     */
    protected $name = 'Dial';
}
