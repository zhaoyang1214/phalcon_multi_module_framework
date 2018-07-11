<?php
use Phalcon\Cli\Task;

class TestTask extends Task
{
    public function mainAction()
    {
        echo "This is the cli test task and the main action" . PHP_EOL;
        var_dump($this->dispatcher->getParams());
    }
    
    public function testAction()
    {
        echo "This is the cli test task and the test action" . PHP_EOL;
        var_dump($this->dispatcher->getParams());
    }
}