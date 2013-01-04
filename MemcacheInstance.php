<?php

namespace SM\MemcacheBundle;

/**
 * 
 * @author Nicolas Potier <nicolas.potier@acseo-conseil.fr>
 */
class MemcacheInstance
{
	private $config;
	private $options;
	
	public function __construct($config, $options)
	{
		$this->config = $config;
		$this->options = $options;
	}
	
	public function getInstance($instanceName)
	{
		if (!isset($this->config["instances"][$instanceName])) {
			throw new \Exception("Unable to load memcache instance $instanceName because it's not defined");
		}
		
		return $this->createInstance($this->config["instances"][$instanceName]["host"], 
				                     $this->config["instances"][$instanceName]["port"],
									 $this->config["use_mock"],
									 $this->config["class"],
									 $this->options);
	}
    /**
     * Creates the instance. The
     * @param string $host memcached host
     * @param int $port port to memcache instance
     * @param bool $use_mock if the factory should return a mock instanc
     * @param string $memcacheClass what implementation of memcached to use.
     * @param array $options options for \Memcached class
     * @throws \Exception if unable to connect to memcache
     * @return object
     */
    private function createInstance($host, $port, $use_mock, $memcacheClass, array $options = array())
    {
    	echo "MemcacheInstance->create";
        if ($use_mock) {
            return new MockMemcache;
        }
        
        $memcache = new $memcacheClass();

        if ($memcache instanceof \Memcache) {
            /** @var \Memcache $memcache */
            if (!$memcache->connect($host, $port)) {
                throw new \Exception("Could not connect to memcache service on $host:$port");
            }
        } else {
            /** @var \Memcached $memcache */
            $memcache->addServer($host, $port);
            foreach ($options as $optionName => $optionValue) {
                $memcache->setOption($optionName, $optionValue);
            }
        }

        return $memcache;
    }
}