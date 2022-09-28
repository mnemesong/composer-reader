<?php

namespace Mnemesong\ComposerReader;

class ComposerConfig
{
    protected array $conf;
    protected string $confFilePath;

    /**
     * @param array $conf
     * @param string $confFilePath
     */
    public function __construct(array $conf, string $confFilePath)
    {
        $this->conf = $conf;
        $this->confFilePath = $confFilePath;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        return $this->conf[$key] ?? null;
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->conf;
    }

    /**
     * @param string $nameSpace
     * @return string
     */
    public function getPathByNamespace(string $nameSpace): string
    {
        $namespacesPsr4 = [];
        if(isset($this->conf["autoload"])) {
            $namespacesPsr4 = $this->conf["autoload"]["psr-4"] ?? [];
        }

        $ds = DIRECTORY_SEPARATOR;
        $variants = [];
        foreach ($namespacesPsr4 as $ns => $p)
        {
            if($this->nameSpaceFound($nameSpace, $ns)) {
                $strTail = mb_substr($nameSpace, strlen($ns));
                $strData = explode($ds, $strTail);
                if(strlen($strData[0]) === 0) {
                    array_shift($strData);
                }
                $confFilePath = mb_substr(
                    $this->confFilePath,
                    0,
                    strlen($this->confFilePath) - strlen($ds . 'composer.json')
                );
                return $confFilePath . $ds . substr($p, 0, strlen($p) - 1) . $ds . implode($ds, $strData);
            }
        }

        throw new \Error('Not found namespace for this path');
    }

    public function getNamespaceByPath(string $filePath): string
    {
        $namespacesPsr4 = [];
        if(isset($this->conf["autoload"])) {
            $namespacesPsr4 = $this->conf["autoload"]["psr-4"] ?? [];
        }

        $ds = DIRECTORY_SEPARATOR;
        $variants = [];
        $configFilePath = mb_substr($this->confFilePath, 0, strlen($this->confFilePath) - strlen($ds . 'composer.json'));
        foreach ($namespacesPsr4 as $ns => $p)
        {
            $subP = mb_substr($p, 0, strlen($p) - 1);
            if(mb_strpos($filePath, $configFilePath . $ds . $subP) === 0) {
                $tail = explode($ds, mb_substr($filePath, strlen($configFilePath . $ds . $subP)));
                $tail = array_filter($tail, fn(string $s) => (strlen($s) > 0));
                $ns = mb_substr($ns, 0, strlen($ns) - 1);
                return implode("\\", (count($tail) > 0) ? array_merge([$ns], $tail) : [$ns]);
            }
        }
        throw new \Error('Had not found namespace');
    }

    protected function nameSpaceFound(string $searchableNamespace, string $namespaceFromConfig): bool
    {
        return mb_strpos($searchableNamespace, $namespaceFromConfig) === 0;
    }
}