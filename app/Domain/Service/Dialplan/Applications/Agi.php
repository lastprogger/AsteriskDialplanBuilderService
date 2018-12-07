<?php


namespace App\Domain\Service\Dialplan\Applications;


class Agi extends AbstractDialplanApplication
{
    protected $name = 'Agi';

    public function __construct(string $command, array $args = [])
    {
        $appData = $command;

        if (empty($postData)) {
            $args    = implode('|', $args);

            if(!empty($args)){
                $appData = $appData . '|' . implode('|', [$args]);
            }
        }

        parent::__construct($appData);
    }
}