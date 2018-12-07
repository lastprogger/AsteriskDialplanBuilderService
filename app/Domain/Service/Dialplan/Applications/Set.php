<?php


namespace App\Domain\Service\Dialplan\Applications;


class Set extends AbstractDialplanApplication
{
    protected $name = 'Set';

    public function __construct(string $data)
    {
        parent::__construct($data);
    }
}