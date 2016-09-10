<?php
/**
 * Created by PhpStorm.
 * User: jasmith
 * Date: 9/9/2016
 * Time: 2:00 PM.
 */

namespace Jeetendra\SymfonyLogViewerBundle\Helper;

class LogParser implements ParserInterface
{
    protected $line;

    /**
     * Parses one single log line.
     */
    public function parseLine($line)
    {
        if (!$line) {
            throw new \Exception('string can not be empty');
        }

        $this->line = $line;

        $log = new \stdClass();
        $log->datetime = $this->getDateTime();
        $log->channel = $this->getChannel();
        $log->level = $this->getLevel();
        $log->message = $this->getMessage();

        return $log;
    }

    protected function getDateTime()
    {
        return substr($this->line, 0, 21);
    }

    protected function getLevel()
    {
        $chanel_level = $this->getChannelLevel();

        if (!$chanel_level) {
            return;
        }

        $data = explode('.', $chanel_level);

        if (array_key_exists(1, $data)) {
            return $data[1];
        }

        return;
    }

    protected function getChannel()
    {
        $chanel_level = $this->getChannelLevel();

        if (!$chanel_level) {
            return;
        }

        $data = explode('.', $chanel_level);

        if (array_key_exists(0, $data)) {
            return $data[0];
        }

        return;
    }

    protected function getMessage()
    {
        return substr($this->line, 23 + strlen($this->getChannelLevel()));
    }

    protected function getChannelLevel()
    {
        $data = substr($this->line, 22);

        $data = explode(':', $data);

        if (array_key_exists(0, $data)) {
            return $data[0];
        }

        return;
    }
}
