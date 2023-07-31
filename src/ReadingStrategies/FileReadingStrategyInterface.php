<?php

namespace App\ReadingStrategies;

use App\Exception\CannotReadFileException;
use App\Exception\FileNotFoundException;

interface FileReadingStrategyInterface
{
    /**
     * @throws FileNotFoundException
     * @throws CannotReadFileException
     */
    public function read(string $fileName): string;
}