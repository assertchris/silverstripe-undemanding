<?php

namespace SilverStripe\Undemanding;

trait Logger
{
    /**
     * Logs a message.
     *
     * @param string $message
     */
    protected function log($message)
    {
        print sprintf("%s\n", $message);
    }
}
