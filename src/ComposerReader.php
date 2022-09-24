<?php

namespace Mnemesong\ComposerReader;

use Webmozart\Assert\Assert;

class ComposerReader
{
    public static function findAndParse(string $startDir = ''): ComposerConfig
    {
        $path = (new self())->searchComposerJsonPath($startDir);
        $fileContent =  file_get_contents($path);
        $config = json_decode($fileContent, true);
        return new ComposerConfig($config);
    }

    protected function searchComposerJsonPath(string $startDir = ''): string
    {
        if($startDir === '') {
            $startDir = __DIR__;
        }
        $ds = DIRECTORY_SEPARATOR;
        for($path = explode($ds, $startDir); count($path) > 0; array_pop($path))
        {
            $curPath = implode($ds, $path) . $ds . 'composer.json';
            if(file_exists($curPath)) {
                return $curPath;
            }
        }
        throw new \Error("Cant find composer.json file");
    }
}