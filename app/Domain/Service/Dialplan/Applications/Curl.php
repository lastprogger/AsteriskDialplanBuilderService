<?php


namespace App\Domain\Service\Dialplan\Applications;


class Curl extends AbstractDialplanApplication
{
    protected $name = 'Curl';

    public function __construct(string $url, array $postData = [])
    {
        $appData = $url;

        if (empty($postData)) {
            $postDataAsString = implode('&', $postData);
            $appData          = implode(',', [$appData, $postDataAsString]);
        }

        parent::__construct($appData);
    }
}
