<?php

declare(strict_types=1);

namespace App;

use App\Exception\UnableToDownloadFileException;

class FileDownloader implements FileDownloaderInterface
{
    public function __construct(private readonly HttpClient $client)
    {
    }

    /**
     * @throws UnableToDownloadFileException
     */
    public function download(string $url): string
    {
        return $this->client->download($url);
    }
}
