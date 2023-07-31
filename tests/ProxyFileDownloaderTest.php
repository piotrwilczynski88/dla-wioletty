<?php

declare(strict_types=1);

namespace Test\App;

use App\FileDownloaderInterface;
use App\ProxyFileDownloader;
use PHPUnit\Framework\TestCase;

class ProxyFileDownloaderTest extends TestCase
{
    public function testDownload_WithNotCachedUrl_WillDownloadAndReturnValue(): void
    {
        // ARRANGE
        $url = 'https://testurl.com/file.txt';
        $fileContents = 'file contents';
        $fileDownloader = $this->prophesize(FileDownloaderInterface::class);
        $fileDownloader->download($url)->willReturn($fileContents);

        // ACT
        $testSubject = new ProxyFileDownloader($fileDownloader->reveal());
        $result = $testSubject->download($url);

        // ASSERT
        $this->assertSame($fileContents, $result);
        $fileDownloader->download($url)->shouldHaveBeenCalled();
    }

    public function testDownload_WithDifferentUrl_WillReturnItsValue(): void
    {
        // ARRANGE
        $url1 = 'https://testurl.com/file1.txt';
        $fileContents1 = 'file contents 1';
        $url2 = 'https://testurl.com/file2.txt';
        $fileContents2 = 'file contents 2';
        $url3 = 'https://testurl.com/file3.txt';
        $fileContents3 = 'file contents 3';

        $fileDownloader = $this->prophesize(FileDownloaderInterface::class);
        $fileDownloader->download($url1)->willReturn($fileContents1);
        $fileDownloader->download($url2)->willReturn($fileContents2);
        $fileDownloader->download($url3)->willReturn($fileContents3);

        // ACT
        $testSubject = new ProxyFileDownloader($fileDownloader->reveal());
        $result1 = $testSubject->download($url1);
        $result2 = $testSubject->download($url2);
        $result3 = $testSubject->download($url3);

        // ASSERT
        $this->assertSame($fileContents1, $result1);
        $this->assertSame($fileContents2, $result2);
        $this->assertSame($fileContents3, $result3);
    }

    public function testDownload_WithMultipleCallsForTheSameUrl_WillDownloadOnlyOnce(): void
    {
        // ARRANGE
        $url = 'https://testurl.com/file.txt';
        $fileContents = 'file contents';
        $fileDownloader = $this->prophesize(FileDownloaderInterface::class);
        $fileDownloader->download($url)->willReturn($fileContents);

        // ACT
        $testSubject = new ProxyFileDownloader($fileDownloader->reveal());
        $testSubject->download($url);
        $testSubject->download($url);

        // ASSERT
        $fileDownloader->download($url)->shouldHaveBeenCalledOnce();
    }
}
