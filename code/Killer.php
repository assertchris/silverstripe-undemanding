<?php

namespace SilverStripe\Undemanding;

trait Killer
{
    /**
     * Kills processes by id.
     *
     * @param string[] $ids
     */
    protected function kill($ids)
    {
        foreach ($ids as $id) {
            $this->exec(sprintf("kill -9 %s", $id));
        }
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
