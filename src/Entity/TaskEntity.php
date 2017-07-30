<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 12:18 PM
 */

namespace Duosystem\Entity;


class TaskEntity extends AbstractEntity
{
    /**
     * @var boolean $situation
     */
    private $situation;

    /**
     * @var \DateTime $dtBegin
     */
    private $dtBegin;

    /**
     * @var \DateTime $dtEnd
     */
    private $dtEnd;

    /**
     * @var TaskEntity $taskStatus
     */
    private $taskStatus;

    /**
     * @return mixed
     */
    public function getSituation(): int
    {
        return $this->situation;
    }

    /**
     * @param mixed $situation
     * @return TaskEntity
     */
    public function setSituation(int $situation): TaskEntity
    {
        $this->situation = $situation;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtBegin(): \DateTime
    {
        return $this->dtBegin;
    }

    /**
     * @param \DateTime $dtBegin
     * @return TaskEntity
     */
    public function setDtBegin(\DateTime $dtBegin): TaskEntity
    {
        $this->dtBegin = $dtBegin;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtEnd(): \DateTime
    {
        return $this->dtEnd;
    }

    /**
     * @param \DateTime $dateEnd
     * @return TaskEntity
     */
    public function setDtEnd(\DateTime $dateEnd): TaskEntity
    {
        $this->dtEnd = $dateEnd;
        return $this;
    }

    /**
     * @return int
     */
    public function getTaskStatus(): int
    {
        return $this->taskStatus;
    }

    /**
     * @param TaskEntity $taskStatus
     * @return TaskEntity
     */
    public function setTaskStatus(int $taskStatus): TaskEntity
    {
        $this->taskStatus = $taskStatus;
        return $this;
    }


}