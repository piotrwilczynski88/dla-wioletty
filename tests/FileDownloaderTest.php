<?php

declare(strict_types=1);

namespace Test\App;

use App\FileDownloader;
use App\HttpClient;
use PHPUnit\Framework\TestCase;

class FileDownloaderTest extends TestCase
{
    public function testDownload_ReturnsValueReturnedByHttpClient(): void
    {
        // ARRANGE
        $url = 'https://testurl.com/file.txt';
        $fileContents = 'file contents';
        $httpClient = $this->prophesize(HttpClient::class);
        $httpClient->download($url)->willReturn($fileContents);

        // ACT
        $testSubject = new FileDownloader($httpClient->reveal());
        $result = $testSubject->download($url);

        // ASSERT
        $this->assertSame($fileContents, $result);
    }
}
