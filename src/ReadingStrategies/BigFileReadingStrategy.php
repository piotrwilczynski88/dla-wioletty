<?php

namespace App\ReadingStrategies;

use App\Exception\CannotReadFileException;
use App\Exception\FileNotFoundException;

class BigFileReadingStrategy implements FileReadingStrategyInterface
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
        $handle = $this->getFileHandle($fileName);

        return $this->getFileContentsByChunks($handle);
    }

    /**
     * @throws CannotReadFileException
     * @returns resource
     */
    private function getFileHandle(string $fileName)
    {
        $handle = fopen($fileName, "r");
        if (false === $handle) {
            throw new CannotReadFileException($fileName);
        }

        return $handle;
    }

    /**
     * @param resource $handle
     */
    private function getFileContentsByChunks($handle): string
    {
        $result = '';
        while (!feof($handle)) {
            $result .= fgets($handle, 4096);
        }
        fclose($handle);

        return $result;
    }
}