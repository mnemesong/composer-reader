<?php

namespace Mnemesong\ComposerReaderTestUnit;

use Mnemesong\ComposerReader\ComposerReader;
use PHPUnit\Framework\TestCase;

class ComposerReaderTest extends TestCase
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
        $truePath = explode($ds, __DIR__);
        array_pop($truePath);
        $truePath[] = 'composer.json';
        $truePath = implode($ds, $truePath);
        $this->assertEquals($truePath, $reader->searchComposerJsonPath());
    }

    public function testGetConfig(): void
    {
        $config = ComposerReader::findAndParse();
        $this->assertEquals("mnemesong/composer-reader", $config->get('name'));
    }

    public function testGetDir(): void
    {
        $config = ComposerReader::findAndParse();
        $ds = DIRECTORY_SEPARATOR;
        $this->assertEquals(
            __DIR__ . $ds . 'dirSearchTest',
            $config->getPathByNamespace('Mnemesong\ComposerReaderTestUnit\dirSearchTest')
        );
    }

    public function testGetNamespace(): void
    {
        $config = ComposerReader::findAndParse();
        $ds = DIRECTORY_SEPARATOR;
        $this->expectOutputString('');
        $this->assertEquals(
            'Mnemesong\ComposerReaderTestUnit',
            $config->getNamespaceByPath(__DIR__)
        );
    }
}