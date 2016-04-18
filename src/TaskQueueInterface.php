<?php

namespace goreilly\WebConnector;

/**
 * Must be serializeable to we can persist it between requests.
 */
interface TaskQueueInterface
{
    /**
     * @return int Current number of elements in the queue
     */
    public function count();

    /**
     * @return int The size of the queue when it was locked
     */
    public function getMax();

    /**
     * @return TaskInterface|null
     */
    public function pop();

    /**
     * @param TaskInterface $task
     */
    public function add(TaskInterface $task);
}