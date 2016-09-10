<?php

namespace Jeetendra\SymfonyLogViewerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    public function getLogs($limit, $offset)
    {
        $logs = array();

        $parser = $this->getParser();

        $count = $this->getTotalCount();


        for($i = $offset; $i <= ($limit + $offset); $i++) {

            if($count < $i) {
                break;
            }

            if($line = $this->getLine($i)) {
                $logs[] = $parser->parseLine($line);
            }

        }

        return array(
            'count' => $count,
            'logs' => $logs
        );
    }

    private function getParser()
    {
        return $this->container->has('symfonylog_viewer.parser_instance')
            ? $this->container->get('symfonylog_viewer.parser_instance')->getInstance()
            : null;
    }

    private function getTotalCount()
    {
        $count = 0;

        $file = $this->getLogFile();

        if(!$file) {
            return $count;
        }

        $fp = fopen( $file, 'r');

        while( !feof( $fp)) {
            fgets( $fp);
            $count++;
        }

        fclose( $fp);

        return $count;
    }

    private function getLine($line_number)
    {
        if($line_number > $this->getTotalCount()) {
            return;
        }

        $file = $this->getLogFile();

        if(!$file) {
            return;
        }

        $file = new \SplFileObject($file);

        $file->seek($line_number);

        if($file->valid()) {
            return $file->getCurrentLine();
        }

        return;
    }

    private function getLogFile()
    {
        $kernel = $this->get('kernel');

        $log_file = sprintf('%s/logs/%s.log', $kernel->getRootDir(), $kernel->getEnvironment());

        if(!file_exists($log_file)) {
            return;
        }

        return $log_file;
    }





}
