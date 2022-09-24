<?php

namespace Mnemesong\ComposerReader;

class ComposerConfig
{
    protected array $conf;

    /**
     * @param array $conf
     */
    public function __construct(array $conf)
    {
        $this->conf = $conf;
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
}