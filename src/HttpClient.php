<?php

declare(strict_types=1);

namespace App;

use App\Exception\UnableToDownloadFileException;

class HttpClient
{
    /**
     * @throws UnableToDownloadFileException
     */
    public function download(string $url): string
    {
        $result = file_get_contents($url);
        if (false === $result) {
            throw new UnableToDownloadFileException();
        }

        return $result;
    }
}
