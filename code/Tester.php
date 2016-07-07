<?php

namespace SilverStripe\Undemanding;

use Undemanding\Client\Page;
use Undemanding\Client\Tester as BaseTester;

trait Tester
{
    use BaseTester {
        BaseTester::visit as baseVisit;
    }

    /**
     * @var string
     */
    private static $host = "127.0.0.1";

    /**
     * @var int
     */
    private static $port = 9000;

    /**
     * @param string $host
     *
     * @return $this
     */
    public function setHost($host)
    {
        static::$host = $host;

        return $this;
    }

    /**
     * @param int $port
     *
     * @return $this
     */
    public function setPort($port)
    {
        static::$port = $port;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return static::$host;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return static::$port;
    }

    /**
     * @param string $address
     *
     * @return Page
     */
    public function visit($address = "")
    {
        $host = $this->getHost();
        $port = $this->getPort();

        return $this->baseVisit("http://{$host}:{$port}/{$address}");
    }
}
