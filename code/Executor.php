<?php

namespace SilverStripe\Undemanding;

trait Executor
{
    /**
     * Runs a command silently and in the background.
     *
     * @param string $command
     *
     * @param bool $silent
     * @param bool $background
     *
     * @return array|string
     */
    protected function exec($command, $silent = true, $background = true)
    {
        if ($silent) {
            $command .= " > /dev/null 2> /dev/null";
        }

        if ($background) {
            $command .= " &";
        }

        exec($command, $output);

        return $output;
    }
}
