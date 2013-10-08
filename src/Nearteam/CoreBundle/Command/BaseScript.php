<?php
namespace Nearteam\CoreBundle\Command;

use Nearteam\CoreBundle\Exception\NotImplementedException;
use Nearteam\CoreBundle\Exception\LockConflictException;
use Nearteam\Common\Exception\InvalidArgumentException;

abstract class BaseScript
{
    const EXECUTION_MODE_ONCE = 0;
    const EXECUTION_MODE_DAEMON = 1;

    /**
     * Determine if program loops
     */
    private $executionMode = self::EXECUTION_MODE_ONCE;

    /**
     * Script name is used at several places : log file name, lock file name
     * @var string
     */
    private $scriptName;

    /**
     * Shard field name
     * @var string
     */
    private $shardField;

    /**
     * List of shard values
     * @var array(int)
     */
    private $shardList;

    /**
     * Configured default shard
     * @var int
     */
    protected $shardCurrent;

    /**
     * Number of shards for this database
     * @var int
     */
    protected $shardCount;

    /**
     * Number of the loop
     * @var int
     */
    protected $loopNumber;

    /**
     * @var Nearteam\Common\Component\ConnectionManager\ConnectionManager
     */
    private $connectionManager;

    /**
     * Directory where lock will be written
     * @var string
     */
    private $lockDirectory;

    /**
     * Number of microseconds between two loops
     * @var int
     */
    private $waitTime = 1000000;

    /**
     * Shall continue execution
     */
    private $sigTermReceived = false;
    /**
     * logger
     * @var object
     */
    protected $logger;
    
    /**
     * Memcache manager
     * @var Nearteam\Common\Component\ConnectionManager\Memcache
     */
    protected $memcache;
    
    /**
     * Set logger
     *
     * @param Logger
     */
    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
    
    /**
     * Set Memcache
     *
     * @param Memcache
     */
    public function setMemcache(Memcache $memcache)
    {
        $this->memcache = $memcache;
    }
    
    /**
     * @param ConnectionManager $connectionManager
     */
    public function setConnectionManager($connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    /**
     * Set scriptName
     * @param string $scriptName
     */
    public function setScriptName($scriptName)
    {
        $this->scriptName = $scriptName;
    }

    /**
     * Set directory where lock will be written
     * @param string $lockDirectory
     */
    public function setLockDirectory($lockDirectory)
    {
        $this->lockDirectory = $lockDirectory;
    }

    /**
     * Set shardList
     *
     * @param string $shardField
     * @param array(int) $shardList
     * @param string $moduleName
     * @throws InvalidArgumentException
     */
    public function setShardList($shardField, $shardList, $moduleName)
    {
        if (!$this->connectionManager->isValidShardList($moduleName, $shardList)) {
            throw new InvalidArgumentException('shardList', $shardList, 'Shards values are correct');
        }

        $this->shardField = $shardField;
        $this->shardList = $shardList;
        $this->shardCount = $this->connectionManager->getShardCountForModule($moduleName);
    }

    /**
     * Set working shard
     * @param int $shardNb
     */
    private function setShardCurrent($shardNb)
    {
        $this->connectionManager->setShardingDefaults($this->shardField, $shardNb);
        $this->shardCurrent = $shardNb;
    }

    /**
     * Defines execution mode
     *
     * @param ScriptBusiness::EXECUTION_MODE_* $executionMode
     */
    public function setExecutionMode($executionMode)
    {
        $this->executionMode = $executionMode;
    }

    /**
     * Return path to lock file
     * @return string
     */
    private function getLockFullPath()
    {
        return $this->lockDirectory . (substr($this->lockDirectory, -1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR) . $this->scriptName . '.pid';
    }

    /**
     * Write a lock File
     * Throws an exception if file already exists
     */
    protected function Lock()
    {
        $path = $this->getLockFullPath();

        if (file_exists($path)) {
            throw new LockConflictException('File ' . $path . ' already exists');
        }

        if (!is_dir($this->lockDirectory)) {
            if (!mkdir($this->lockDirectory, 0755, true)) {
                throw new LockConflictException('Unable to create directory : ' . $this->lockDirectory);
            }
        }

        $file = fopen($path, 'w');
        if (!$file) {
            throw new LockConflictException('Unable to create lock file : ' . $path);
        }

        fwrite($file, posix_getpid());
        fclose($file);

        $this->log('Lock file : ' . $path);
    }

    /**
     * Tests if lock still exists
     */
    protected function isLockStillThere()
    {
        return file_exists($this->getLockFullPath());
    }

    /**
     * Delete lock file
     */
    protected function releaseLock()
    {
        unlink($this->getLockFullPath());
    }

    /**
     * Command to run from outside
     */
    public function run()
    {
        try {
            if ($this->executionMode == self::EXECUTION_MODE_DAEMON) {
                declare(ticks=1) ;
                if (!pcntl_signal(\SIGTERM, array($this, 'sigHandler'))) {
                    throw new \Exception('Unable to register signal handler');
                }
                if (!pcntl_signal(\SIGINT, array($this, 'sigHandler'))) {
                    throw new \Exception('Unable to register signal handler');
                }
                $this->log('Signal handler registered');
            }

            $this->Lock();
            $this->log('Script start');

            switch ($this->executionMode) {
            case self::EXECUTION_MODE_DAEMON:
                $this->runDaemon();
                break;
            case self::EXECUTION_MODE_ONCE:
                $this->runOnce();
                break;
            }

            $this->log('Script stop');
            $this->releaseLock();
        } catch (\Exception $e) {
            $this->logger
                    ->err("Exception triggered: " . $e->getMessage() . "\n" . $e->getFile() . "(" . $e->getLine() . ")" . "\n" . $e->getTraceAsString() . "\n");
            return 1;
        }

        return 0;
    }

    /**
     * Posix signal handler
     * @param int $signalNumber
     */
    public function sigHandler($signalNumber)
    {
        switch ($signalNumber) {
            case \SIGINT:
                $this->log("Received SIGINT signal: waiting end of loop to exit.\n");
                $this->sigTermReceived = true;
                break;
            case \SIGTERM:
                $this->log("Received SIGTERM signal: waiting end of loop to exit.\n");
                $this->sigTermReceived = true;
                break;
            default:
                $this->log("Received $signalNumber signal: do nothing\n");
        }
    }

    /**
     * Execute process on everyShard
     */
    private function runDaemon()
    {
        $this->loopNumber = 0;

        while (!$this->sigTermReceived && $this->isLockStillThere()) {
            if (is_null($this->shardList)) {
                $this->process();
            } else {
                foreach ($this->shardList as $shardNb) {
                    $this->setShardCurrent($shardNb);
                    $this->process();
                    $this->wait();
                }
            }

            $this->loopNumber++;
        }
    }

    /**
     * Mark a pause between 2 loops
     */
    private function wait()
    {
        usleep($this->waitTime);
    }

    /**
     * Execute process once
     */
    private function runOnce()
    {
        if (is_null($this->shardList)) {
            $this->process();
        } else {
            foreach ($this->shardList as $shardNb) {
                $this->log('Shard [' . $this->shardField . '#' . $shardNb . '] : ');
                $this->connectionManager->closeConnections();
                $this->setShardCurrent($shardNb);

                $this->process();
            }
        }

    }

    /**
     * Log a message
     * @param string $message
     */
    protected function log($message)
    {
        if (!is_null($this->shardCurrent)) {
            $message = "[$this->shardField#$this->shardCurrent] " . $message;
        }

        $this->logger->info($message);
    }

    /**
     * Child Classes should implement this method
     * Body of script
     */
    protected abstract function process();
}
