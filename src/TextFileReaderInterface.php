<?php

declare(strict_types=1);

namespace App;

interface TextFileReaderInterface
{
    public function read(string $filename): string;
}
