<?php

namespace SM\MemcacheBundle;

/**
 * Factoryclass for memcache instances.
 *
 * @author Tarjei Huse (tarjei - a - scanmine.com) http://www.kraken.no
 */
class MemcacheFactory
{
    /**
     * Creates the instance. The
     * @param  string     $host          memcached host
     * @param  int        $port          port to memcache instance
     * @param  bool       $use_mock      if the factory should return a mock instanc
     * @param  string     $memcacheClass what implementation of memcached to use.
     * @param  array      $options       options for \Memcached class
     * @throws \Exception if unable to connect to memcache
     * @return object
     */
    public static function create($config, $options)
    {
        return new MemcacheInstance($config, $options);
    }
}
