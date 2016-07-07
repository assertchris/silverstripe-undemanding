<?php

namespace SilverStripe\Undemanding;

use Exception;
use PHPUnit_Framework_AssertionFailedError;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_TestListener;
use PHPUnit_Framework_TestSuite;

class Listener implements PHPUnit_Framework_TestListener
{
    use Tester;

    /**
     * @var bool
     */
    private $running = false;

    /**
     * @var int[]
     */
    private $pid = [];

    /**
     * @var bool
     */
    private static $run = false;

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception $e
     * @param float $time
     */
    public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        // TODO: read https://en.wikipedia.org/wiki/Interface_segregation_principle
    }

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_Test $test
     * @param PHPUnit_Framework_AssertionFailedError $e
     * @param float $time
     */
    public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        // TODO: read https://en.wikipedia.org/wiki/Interface_segregation_principle
    }

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception $e
     * @param float $time
     */
    public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        // TODO: read https://en.wikipedia.org/wiki/Interface_segregation_principle
    }

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception $e
     * @param float $time
     */
    public function addRiskyTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        // TODO: read https://en.wikipedia.org/wiki/Interface_segregation_principle
    }

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_Test $test
     * @param Exception $e
     * @param float $time
     */
    public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
    {
        // TODO: read https://en.wikipedia.org/wiki/Interface_segregation_principle
    }

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function startTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        static::undemandingStart();
        $this->serveStart();
    }

    /**
     * Starts the development server.
     */
    private function serveStart()
    {
        if (static::$run) {
            return;
        }

        static::$run = true;

        print "Running dev/build...\n";
        @exec("framework/sake dev/build flush=1 > /dev/null 2> /dev/null");

        print "Finding open port...\n";

        while (!$this->addressAvailable($this->getHost(), $this->getPort())) {
            $this->setPort($this->getPort() + 1);
        }

        if (!$this->running) {
            $host = $this->getHost();
            $port = $this->getPort();

            $hash = spl_object_hash($this);

            print "Starting development server...\n";
            $command = "framework/sake dev/tasks/SilverStripe-Serve-Task hash={$hash} host={$host} port={$port} > /dev/null 2> /dev/null &";

            exec($command, $output);

            $command = "ps -o pid,command | grep {$hash}";
            @exec($command, $output);

            if (count($output) > 0) {
                foreach ($output as $line) {
                    $parts = explode(" ", $line);
                    $this->pid[] = $parts[0];
                }
            }

            sleep(1);
        }
    }

    /**
     * Check if something is running at a specific host/port.
     *
     * @param string $host
     * @param int $port
     *
     * @return bool
     */
    private function addressAvailable($host, $port)
    {
        $handle = curl_init($host);

        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($handle, CURLOPT_HEADER, true);
        curl_setopt($handle, CURLOPT_NOBODY, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_PORT, $port);

        $response = curl_exec($handle);

        curl_close($handle);

        if (empty($response)) {
            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_TestSuite $suite
     */
    public function endTestSuite(PHPUnit_Framework_TestSuite $suite)
    {
        static::undemandingStop();
        $this->serveStop();
    }

    /**
     * Stops the development server.
     */
    private function serveStop()
    {
        foreach ($this->pid as $pid) {
            $command = "kill -9 {$pid} > /dev/null 2> /dev/null &";
            @exec($command, $output);
        }
    }

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_Test $test
     */
    public function startTest(PHPUnit_Framework_Test $test)
    {
        // TODO: read https://en.wikipedia.org/wiki/Interface_segregation_principle
    }

    /**
     * @inheritdoc
     *
     * @param PHPUnit_Framework_Test $test
     * @param float $time
     */
    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        // TODO: read https://en.wikipedia.org/wiki/Interface_segregation_principle
    }
}
