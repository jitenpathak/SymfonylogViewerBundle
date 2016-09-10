<?php

namespace Jeetendra\SymfonyLogViewerBundle\Helper\Factory;

use Jeetendra\SymfonyLogViewerBundle\Helper\LogParser;

class LogFactory implements LogFactoryInterface
{
    public function getInstance()
    {
        return new LogParser();
    }
}
