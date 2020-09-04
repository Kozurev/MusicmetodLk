<?php


namespace App\Helpers;

/**
 * Class Cache
 * @package App\Helpers
 */
class Cache
{
    /**
     * @var array
     */
    private array $storage = [];

    /**
     * @param string $tag
     * @return bool
     */
    public function exists(string $tag) : bool
    {
        return isset($this->storage[$tag]);
    }

    /**
     * @param string $tag
     * @param $value
     */
    public function set(string $tag, $value)
    {
        $this->storage[$tag] = $value;
    }

    /**
     * @param string $tag
     * @param null $default
     * @return mixed|null
     */
    public function get(string $tag, $default = null)
    {
        return $this->storage[$tag] ?? $default;
    }
}