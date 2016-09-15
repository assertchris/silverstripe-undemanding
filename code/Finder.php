<?php

namespace SilverStripe\Undemanding;

trait Finder
{
    /**
     * Find processes by pattern.
     *
     * @param string $match
     *
     * @return array
     */
    protected function find($match)
    {
        $ids = [];
        $output = $this->exec(sprintf("ps -o pid,command | grep %s", $match), $silent = false, $background = false);

        if (count($output) > 0) {
            foreach ($output as $line) {
                $parts = explode(" ", $line);
                $ids[] = $parts[0];
            }
        }

        return $ids;
    }

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
    abstract protected function exec($command, $silent = true, $background = true);
}
