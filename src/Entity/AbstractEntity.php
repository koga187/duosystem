<?php
/**
 * Created by PhpStorm.
 * User: koga
 * Date: 7/29/17
 * Time: 12:13 PM
 */

namespace Duosystem\Entity;


abstract class AbstractEntity
{
    /**
     * @var int $id
     */
    protected $id;

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $description
     */
    protected $description;

    /**
     * @var \DateTime $dtCreated
     */
    protected $dtCreated;

    /**
     * @var boolean $deleted
     */
    protected $deleted;

    /**
     * @var \DateTime $dtDeleted
     */
    protected $dtDeleted;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AbstractEntity
     */
    public function setId(int $id): AbstractEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return AbstractEntity
     */
    public function setName(string $name): AbstractEntity
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return AbstractEntity
     */
    public function setDescription(string $description): AbstractEntity
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtCreated(): \DateTime
    {
        return $this->dtCreated;
    }

    /**
     * @param \DateTime $dtCreated
     * @return AbstractEntity
     */
    public function setDtCreated(\DateTime $dtCreated): AbstractEntity
    {
        $this->dtCreated = $dtCreated;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     * @return AbstractEntity
     */
    public function setDeleted(bool $deleted): AbstractEntity
    {
        $this->deleted = $deleted;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDtDeleted(): \DateTime
    {
        return $this->dtDeleted;
    }

    /**
     * @param \DateTime $dtDeleted
     * @return AbstractEntity
     */
    public function setDtDeleted(\DateTime $dtDeleted): AbstractEntity
    {
        $this->dtDeleted = $dtDeleted;
        return $this;
    }
}