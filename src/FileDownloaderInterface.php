<?php

declare(strict_types=1);

namespace App;

interface FileDownloaderInterface
{
    public function download(string $url): string;
}
