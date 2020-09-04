<?php


namespace App\Traits;


use App\Helpers\Cache;

/**
 * Trait CacheTrait
 * @package App\Traits
 */
trait CacheTrait
{
    /**
     * @var Cache|null
     */
    public ?Cache $cache = null;

    /**
     * @return Cache
     */
    public function cache() : Cache
    {
        if (is_null($this->cache)) {
            $this->cache = new Cache();
        }
        return $this->cache;
    }
}