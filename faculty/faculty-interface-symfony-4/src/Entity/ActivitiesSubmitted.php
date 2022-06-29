<?php

namespace App\Entity;

use App\Repository\ActivitiesSubmittedRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivitiesSubmittedRepository::class)
 */
class ActivitiesSubmitted
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $activityid;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $studentid;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ProgramClass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Course;

    /**
     * @ORM\Column(type="json")
     */
    private $correctanswers = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $elapsedtime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isvalid;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivityid(): ?int
    {
        return $this->activityid;
    }

    public function setActivityid(int $activityid): self
    {
        $this->activityid = $activityid;

        return $this;
    }

    public function getStudentid(): ?string
    {
        return $this->studentid;
    }

    public function setStudentid(string $studentid): self
    {
        $this->studentid = $studentid;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(?int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function setFile(?string $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getProgramClass(): ?string
    {
        return $this->ProgramClass;
    }

    public function setProgramClass(string $ProgramClass): self
    {
        $this->ProgramClass = $ProgramClass;

        return $this;
    }

    public function getCourse(): ?string
    {
        return $this->Course;
    }

    public function setCourse(string $Course): self
    {
        $this->Course = $Course;

        return $this;
    }

    public function getCorrectanswers(): ?array
    {
        return $this->correctanswers;
    }

    public function setCorrectanswers(array $correctanswers): self
    {
        $this->correctanswers = $correctanswers;

        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getElapsedtime(): ?\DateTimeInterface
    {
        return $this->elapsedtime;
    }

    public function setElapsedtime(?\DateTimeInterface $elapsedtime): self
    {
        $this->elapsedtime = $elapsedtime;

        return $this;
    }

    public function getIsvalid(): ?bool
    {
        return $this->isvalid;
    }

    public function setIsvalid(bool $isvalid): self
    {
        $this->isvalid = $isvalid;

        return $this;
    }
}
