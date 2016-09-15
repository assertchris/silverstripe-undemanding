<?php

namespace SilverStripe\Undemanding\Task;

use BuildTask;
use SilverStripe\Undemanding\Executor;
use SilverStripe\Undemanding\Finder;
use SilverStripe\Undemanding\Killer;
use SilverStripe\Undemanding\Logger;
use SS_HTTPRequest;

class Reset extends BuildTask
{
    use Executor;
    use Finder;
    use Killer;
    use Logger;

    /**
     * @var string
     */
    protected $title = "Clear all serve/undemanding processes";

    /**
     * @var string
     */
    protected $description = "Kills processes which could prevent Undemanding tests from running.";

    /**
     * @inheritdoc
     *
     * @param SS_HTTPRequest $request
     */
    public function run($request)
    {
        $this->kill($this->find("phantomjs"));
        $this->kill($this->find("serve/code/server"));
    }
}
