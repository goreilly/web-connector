<?php
namespace goreilly\WebConnector\Tests;

use goreilly\WebConnector\TaskInterface;
use goreilly\WebConnector\TaskQueue;

class TaskQueueTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @return TestTask
     */
    protected function getTask()
    {
        return new TestTask();
    }

    public function testCount()
    {
        $queue = new TaskQueue();
        $this->assertEquals(0, $queue->count());

        $queue->pop();
        $this->assertEquals(0, $queue->count());

        $task = $this->getTask();

        $queue->add($task);
        $this->assertEquals(1, $queue->count());

        $queue->add($task);
        $this->assertEquals(2, $queue->count());

        $queue->pop();
        $this->assertEquals(1, $queue->count());
    }

    public function testGetMax()
    {

        $queue = new TaskQueue();

        $task = $this->getTask();

        $max = 10;

        for ($i = 0; $i < $max; $i++) {
            $queue->add($task);
        }

        $queue->pop();
        $queue->pop();
        $queue->pop();
        $queue->pop();

        $this->assertEquals($max, $queue->getMax());
    }

    public function testPop()
    {
        /** @var TaskInterface[] $tasks */
        $tasks = [
            $this->getTask(),
            $this->getTask(),
            $this->getTask(),
            $this->getTask(),
            $this->getTask(),
        ];

        $queue = new TaskQueue();

        foreach ($tasks as $task) {
            $queue->add($task);
        }

        foreach ($tasks as $task) {
            $this->assertEquals($task, $queue->pop());
        }

    }

    public function testAdd()
    {
        $queue = new TaskQueue();

        $task = $this->getTask();

        $queue->add($task);
        $this->assertEquals($task, $queue->pop());
    }

    public function testSerialize()
    {
        $queue = new TaskQueue();

        $task = $this->getTask();

        $queue->add($task);

        $serialized = $queue->serialize();

        $copy = new TaskQueue();

        $copy->unserialize($serialized);

        $this->assertEquals($copy, $queue);
    }

}
