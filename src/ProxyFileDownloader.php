<?php

declare(strict_types=1);

namespace App;

use App\Exception\UnableToDownloadFileException;

class ProxyFileDownloader implements FileDownloaderInterface
{
    private array $cache = [];

    public function __construct(private readonly FileDownloaderInterface $fileDownloader)
    {
    }

    /**
     * @throws UnableToDownloadFileException
     */
    public function download(string $url): string
    {
        if (!$this->hasInCache($url)) {
            $fileContents = $this->fileDownloader->download($url);
            $this->storeInCache($url, $fileContents);
        }

        return $this->getCachedValue($url);
    }
    private function hasInCache(string $url): bool
    {
        return isset($this->cache[$url]);
    }

    /**
     * @throws UnableToDownloadFileException
     */
    private function storeInCache(string $url, string $fileContents): void
    {
            $this->cache[$url] = $fileContents;
    }

    private function getCachedValue(string $url): string
    {
        return $this->cache[$url];
    }
}
