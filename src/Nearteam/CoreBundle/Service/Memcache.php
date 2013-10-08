<?php

namespace Nearteam\CoreBundle\Service;

use Nearteam\CoreBundle\Service\VariableControl;
use Nearteam\CoreBundle\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

/**
 * Memcache
 */
class Memcache
{

    /**
     * @var Symfony\Component\HttpKernel\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Core Memcache object
     * @var \Memcache
     */
    private $memcache;

    /**
     * Memcache server list
     * @var array(host => string, port => int)
     */
    private $memcacheConfiguration = null;

    /**
     * In debug mode, do not return anything
     */
    private $debugMode = false;

    /**
     * Number of seconds an written object will persist
     * @var integer
     */

    const MEMCACHE_DEFAULT_PERSISTENCE = 3600;
    const MEMCACHE_PERSISTENCE_1MIN = 60;
    const MEMCACHE_PERSISTENCE_5MIN = 300;
    const MEMCACHE_PERSISTENCE_HOUR = 3600;
    const MEMCACHE_PERSISTENCE_DAY = 86400;

    /**
     * Constructor
     * @param LoggerInterface $logger
     * @param array $memcacheConfiguration
     * @throws Exception
     */
    public function __construct(LoggerInterface $logger, array $memcacheConfiguration)
    {
        $this->logger = $logger;
        $this->setDebugMode(true);

        // memcache configuration
        $this->memcacheConfiguration = $memcacheConfiguration;
        // $this->setDebugMode(true);
        $this->memcache = new \Memcache();
        foreach ($this->memcacheConfiguration as $mcServerConfig) {
            if (!$this->memcache->addServer($mcServerConfig['host'], $mcServerConfig['port'])) {
                throw new \Exception("Unable to add MemCache Server $mcServerConfig[host] : $mcServerConfig[port]");
            }
        }
    }

    /**
     * @param boolean $debugMode
     */
    public function setDebugMode($debugMode)
    {
        VariableControl::checkBool($debugMode);

        $this->debugMode = $debugMode;
    }

    /**
     * Read an entry in MemCache
     *
     * @param string $memcacheKey
     * @return false in object was not found
     */
    public function get($memcacheKey)
    {
        VariableControl::checkString($memcacheKey);

        if ($this->debugMode || empty($this->memcacheConfiguration)) {
            
            return false;
        }

        if (($result = $this->memcache->get($memcacheKey)) !== false) {
            $this->logger->debug('Memcache : ' . $memcacheKey . ' read');
        } else {
            $this->logger->debug('Memcache : ' . $memcacheKey . ' not found');
        }

        return $result;
    }

    /**
     * Read several entries in MemCache
     *
     * @param array(string) $memcacheKeyList
     * @return array(string => mixed). Non-found objects are not returned
     */
    public function getList($memcacheKeyList)
    {
        VariableControl::checkArray($memcacheKeyList);

        if ($this->debugMode || empty($this->memcacheConfiguration)) {
            
            return array ();
        }

        $result = $this->memcache->get($memcacheKeyList);

        if (is_array($result)) {
            $this->logger->debug('Memcache : ' . implode(',', array_keys($result)) . ' read among ' . implode(',', $memcacheKeyList));
        } else {
            $this->logger->debug('Memcache : not found among ' . implode(',', $memcacheKeyList));
        }


        return $result;
    }

    /**
     * Write an entry in memcache
     *
     * @param string $memcacheKey
     * @param mixed $value
     * @param int $persistSeconds
     * @return boolean succeeded
     */
    public function set($memcacheKey, $value, $persistSeconds = self::MEMCACHE_DEFAULT_PERSISTENCE)
    {
        VariableControl::checkString($memcacheKey);
        VariableControl::checkInt($persistSeconds);

        if ($this->debugMode || empty($this->memcacheConfiguration)) {
            
            return;
        }

        $this->logger->debug('Memcache : ' . $memcacheKey . ' written');

        return $this->memcache->set($memcacheKey, $value, MEMCACHE_COMPRESSED, $persistSeconds);
    }

    /**
     * Delete an entry in memcache
     *
     * @param string $memcacheKey
     * @return boolean succeeded
     */
    public function delete($memcacheKey)
    {
        VariableControl::checkString($memcacheKey);

        if ($this->debugMode || empty($this->memcacheConfiguration)) {
            
            return;
        }

        return $this->memcache->delete($memcacheKey);
    }

    // TODO : intégrer la timezone à la clé de cache !

    /**
     * Gives the path result of this function is stored
     * @param object $object
     * @param string $functionName
     * @param array $parameters
     * @return string
     */
    public function getMemcacheKeyFunction($object, $functionName, array $parameters)
    {
        VariableControl::checkString($functionName);
        VariableControl::checkArray($parameters);

        if (method_exists($object, 'getMemcacheKeyFunction')) {
            
            return $object->getMemcacheKeyFunction($functionName, $parameters);
        } else {
            
            return get_class($object) . $functionName . '(' . serialize($parameters) . ')';
        }
    }

    /**
     * If entry is already in memcache, directly return value
     * Else, compute value and store it into memcache
     *
     * @param object $object
     * @param function $functionName
     * @param array $parameters
     * @param integer $persistSeconds
     * @param string|null $memcacheKey
     * @return mixed
     */
    public function cachedCall($object, $functionName, array $parameters = array (), $persistSeconds = self::MEMCACHE_DEFAULT_PERSISTENCE, $memcacheKey = null)
    {
        if (is_null($memcacheKey)) {
            $memcacheKey = $this->getMemcacheKeyFunction($object, $functionName, $parameters);
        } else {
            VariableControl::checkString($memcacheKey);
        }

        $value = $this->get($memcacheKey);
        if ($value === false) {
            $value = call_user_func_array(array ($object, $functionName), $parameters);

            $this->set($memcacheKey, $value, $persistSeconds);
        }

        return $value;
    }

}