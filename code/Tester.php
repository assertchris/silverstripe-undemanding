<?php

namespace SilverStripe\Undemanding;

use Undemanding\Client\Page;
use Undemanding\Client\Tester as BaseTester;

/**
 * @mixin Page
 */
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
        $address = ltrim($address, "./");

        if (stripos($address, "http://") === 0 || stripos($address, "https://") === 0) {
            return $this->baseVisit($address);
        }

        $host = $this->getHost();
        $port = $this->getPort();

        print "formatted: " . sprintf("http://%s:%s/%s", $host, $port, $address) . "\n";

        return $this->baseVisit(sprintf("http://%s:%s/%s", $host, $port, $address));
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return Tester
     */
    public function admin($email = "admin", $password = "password")
    {
        return $this
            ->visit("admin")
            ->fill("[name='Email']", $email)
            ->fill("[name='Password']", $password)
            ->click("[type='submit']")
            ->wait();
    }
}
