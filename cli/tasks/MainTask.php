<?php
use Phalcon\Cli\Task;
use App\Home\Models\Robots;

class MainTask extends Task
{
    public function mainAction()
    {
        echo "This is the cli main task and the main action" . PHP_EOL;
        var_dump($this->dispatcher->getParams());
    }
    
    public function testAction()
    {
        echo "This is the cli main task and the test action" . PHP_EOL;
        var_dump($this->dispatcher->getParams());
    }
    
    public function mysqlAction(){
        $robotsList = Robots::find();
        foreach ($robotsList as $robot){
            echo $robot->id,' ',$robot->name,' ',$robot->type,' ',$robot->weight,PHP_EOL;
        }
    }
    
    public function loggerAction(){
        $this->logger->info('This is an info message2');
        
        $this->di->getLogger()->info('This is an info message3');
        
        $this->getDi()->getLogger()->info('This is an info message4');
        
        $this->di['logger']->info('This is an info message5');
        
        $this->di->get('logger')->info('This is an info message6');
    }
}