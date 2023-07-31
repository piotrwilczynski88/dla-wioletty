<?php

declare(strict_types=1);

namespace App;

class UnixEndOfLineTextFileReaderDecorator implements TextFileReaderInterface
{
    private const CR_EOL = "\r";
    private const LF_EOL = "\n";
    private const CR_LF_EOL = "\r\n";

    public function __construct(private readonly TextFileReaderInterface $wrappedObject)
    {
    }

    public function read(string $filename): string
    {
        return str_replace(
            [self::CR_LF_EOL, self::CR_EOL],
            self::LF_EOL,
            $this->wrappedObject->read($filename)
        );
    }
}
