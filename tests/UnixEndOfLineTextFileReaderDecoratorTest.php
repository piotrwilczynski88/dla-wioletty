<?php

declare(strict_types=1);

namespace App\Tests;

use App\ReadingStrategies\SmallFileReadingStrategy;
use App\TextFileReader;
use App\UnixEndOfLineTextFileReaderDecorator;
use PHPUnit\Framework\TestCase;

class UnixEndOfLineTextFileReaderDecoratorTest extends TestCase
{
    /**
     * @dataProvider provideTestFilesWithDifferentEol
     */
    public function testRead_WithDifferentEol_ReturnsFileContentsWithUnixEol(string $file): void {
        $textFileReader = new TextFileReader(new SmallFileReadingStrategy());
        $testSubject = new UnixEndOfLineTextFileReaderDecorator($textFileReader);

        $fileContents = $testSubject->read($file);

        $unixEol = "\n";
        $this->assertSame(
            "line 1".$unixEol."line 2".$unixEol."line 3",
            $fileContents
        );
    }

    public function provideTestFilesWithDifferentEol(): array
    {
        return [
            'lf eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-lf.txt',
            ],
            'cr eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-cr.txt',
            ],
            'cr lf eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-cr-lf.txt',
            ],
        ];
    }

    public function testRead_WithEolNotBeingEol_ReturnsOneLine(): void
    {
        $textFileReader = new TextFileReader(new SmallFileReadingStrategy());
        $testSubject = new UnixEndOfLineTextFileReaderDecorator($textFileReader);

        $fileContents = $testSubject->read(__DIR__ . '/fixtures/one-line-with-eol-not-being-eol.txt');

        $this->assertSame(
            'Hello,\nWorld\rIs\r\nOk',
            $fileContents
        );
    }
}
