<?php
namespace goreilly\WebConnector;

class TaskQueue implements TaskQueueInterface
{
    /**
     * @var TaskInterface[]
     */
    protected $tasks = [];

    /**
     * @var int Largest the queue ever got
     */
    protected $max;

    /**
     * @return int Current number of elements in the queue
     */
    public function count()
    {
        return count($this->tasks);
    }

    /**
     * @return int The largest size the queue reached
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @return TaskInterface|null
     */
    public function pop()
    {
        $task = null;
        
        if ($this->tasks) {
            $task = array_pop($this->tasks);
        }
        
        return $task;
    }

    /**
     * @param TaskInterface $task
     */
    public function add(TaskInterface $task)
    {
        $this->tasks[] = $task;
        
        $this->max = max($this->max, count($this->tasks));
    }
}