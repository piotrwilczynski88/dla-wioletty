<?php

declare(strict_types=1);

namespace App;

use App\Exception\CannotReadFileException;
use App\Exception\FileNotFoundException;
use App\Exception\UnsupportedFileTypeException;
use App\ReadingStrategies\FileReadingStrategyInterface;

readonly class TextFileReader implements TextFileReaderInterface
{
    public function __construct(private FileReadingStrategyInterface $readingStrategy) {

    }

    /**
     * @throws FileNotFoundException
     * @throws CannotReadFileException
     */
    public function read(string $filename): string
    {
        if (!file_exists($filename)) {
            throw new FileNotFoundException($filename);
        }
        $contentType = mime_content_type($filename) ?? '';
        if ($contentType !== "text/plain") {
            throw new UnsupportedFileTypeException(
                sprintf('Unsupported file type: %s', $contentType),
            );
        }

        return $this->readingStrategy->read($filename);
    }
}
