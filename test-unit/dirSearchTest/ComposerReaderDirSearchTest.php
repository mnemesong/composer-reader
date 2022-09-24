<?php

namespace Mnemesong\ComposerReaderTestUnit\dirSearchTest;

use Mnemesong\ComposerReader\ComposerReader;
use PHPUnit\Framework\TestCase;

class ComposerReaderDirSearchTest extends TestCase
{
    public function testSearchFile()
    {
        $reader = new class extends ComposerReader {
            public function searchComposerJsonPath(string $startDir = ''): string
            {
                return parent::searchComposerJsonPath($startDir);
            }
        };
        $ds = DIRECTORY_SEPARATOR;
        $truePath = __DIR__ . $ds . 'composer.json';
//        $this->expectOutputString('');
        $this->assertEquals($truePath, $reader->searchComposerJsonPath(__DIR__));
    }
}