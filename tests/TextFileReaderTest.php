<?php

declare(strict_types=1);

namespace App\Tests;

use App\Exception\FileNotFoundException;
use App\ReadingStrategies\BigFileReadingStrategy;
use App\ReadingStrategies\FileReadingStrategyInterface;
use App\ReadingStrategies\SmallFileReadingStrategy;
use App\TextFileReader;
use PHPUnit\Framework\TestCase;

class TextFileReaderTest extends TestCase
{
    /**
     * @dataProvider provideTestFilesWithDifferentEolAndReadingStrategies
     */
    public function testRead_ReturnsFileContentsWithOriginalEolCharacters(
        string $file,
        FileReadingStrategyInterface $strategy,
        string $eol
    ): void {
        $testSubject = new TextFileReader($strategy);

        $fileContents = $testSubject->read($file);
        $this->assertSame(
            "line 1".$eol."line 2".$eol."line 3",
            $fileContents
        );
    }

    public function provideTestFilesWithDifferentEolAndReadingStrategies(): array
    {
        return [
            'small file strategy, lf eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-lf.txt',
                'strategy' => new SmallFileReadingStrategy(),
                'eol' => "\n",
            ],
            'small file strategy, cr eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-cr.txt',
                'strategy' => new SmallFileReadingStrategy(),
                'eol' => "\r",
            ],
            'small file strategy, cr lf eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-cr-lf.txt',
                'strategy' => new SmallFileReadingStrategy(),
                'eol' => "\r\n",
            ],
            'big file strategy, lf eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-lf.txt',
                'strategy' => new BigFileReadingStrategy(),
                'eol' => "\n",
            ],
            'big file strategy, cr eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-cr.txt',
                'strategy' => new BigFileReadingStrategy(),
                'eol' => "\r",
            ],
            'big file strategy, cr lf eol' => [
                'file' => __DIR__ . '/fixtures/three-lines-cr-lf.txt',
                'strategy' => new BigFileReadingStrategy(),
                'eol' => "\r\n",
            ],
        ];
    }

    public function testRead_WithNotExistentFile_ThrowsFileNotFoundException(): void
    {
        $testSubject = new TextFileReader(new SmallFileReadingStrategy());

        $this->expectException(FileNotFoundException::class);
        $this->expectExceptionMessage('File this-does-not-exist.txt not found');

        $testSubject->read('this-does-not-exist.txt');
    }
}
