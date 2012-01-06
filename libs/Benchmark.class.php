<?php
class Benchmark {
    private $startTime;
    private $finishTime;

    public function start() {
        $this->startTime = time();
    }

    public function finish() {
        $this->finishTime = time();
    }

    public function getTime() {
        return $this->finishTime - $this->startTime;
    }

    public function displayTime($message) {
        $time = $this->getTime();
        $display = $message . " : " . $time . "\n";
        echo $display;
    }

    public function writeTime($message) {
        $time = $this->getTime();
        $display = $message . " : " . $time . "\n";
        _log($display, "benchmark");
    }
}
