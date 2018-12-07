<?php


namespace App\Domain\Service\Dialplan\Applications;

/**
 * @link http://asterisk.ru/knowledgebase/Asterisk+cmd+authenticate
 *
 */
class Authenticate extends AbstractDialplanApplication
{
    protected $name = 'Authenticate';

    public function __construct(string $password)
    {
        parent::__construct($password);
    }
}
