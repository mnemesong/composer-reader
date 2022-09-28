<?php

namespace Mnemesong\ComposerReaderTestUnit\someDir;

use Mnemesong\ComposerReader\ComposerReader;
use PHPUnit\Framework\TestCase;

class SomeDirNamespaceDefinitionTest extends TestCase
{
    public function testDirInNamespaceDefinition(): void
    {
        $config = ComposerReader::findAndParse();
        $ds = DIRECTORY_SEPARATOR;
        $this->expectOutputString('');
        $this->assertEquals(
            'Mnemesong\ComposerReaderTestUnit\someDir',
            $config->getNamespaceByPath(__DIR__)
        );
    }
}