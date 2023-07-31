<?php

declare(strict_types=1);

namespace App\ReadingStrategies;

use App\Exception\CannotReadFileException;
use App\Exception\FileNotFoundException;

class SmallFileReadingStrategy implements FileReadingStrategyInterface
{
    /**
     * @throws FileNotFoundException
     * @throws CannotReadFileException
     */
    public function read(string $fileName): string
    {
        if (!file_exists($fileName)) {
            throw new FileNotFoundException($fileName);
        }
        $fileContents = file_get_contents($fileName, true);
        if (false === $fileContents) {
            throw new CannotReadFileException($fileName);
        }

        return $fileContents;
    }
}