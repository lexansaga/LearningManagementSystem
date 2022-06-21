<?php

namespace App\Entity;

use App\Repository\ActivitiesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivitiesRepository::class)
 */
class Activities
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activityname;

    /**
     * @ORM\Column(type="json")
     */
    private $questions = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="integer")
     */
    private $facultyload_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $activity_deadline;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActivityname(): ?string
    {
        return $this->activityname;
    }

    public function setActivityname(string $activityname): self
    {
        $this->activityname = $activityname;

        return $this;
    }

    public function getQuestions(): ?array
    {
        return $this->questions;
    }

    public function setQuestions(array $questions): self
    {
        $this->questions = $questions;

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

    public function getFacultyloadId(): ?int
    {
        return $this->facultyload_id;
    }

    public function setFacultyloadId(int $facultyload_id): self
    {
        $this->facultyload_id = $facultyload_id;

        return $this;
    }

    public function getActivityDeadline(): ?\DateTimeInterface
    {
        return $this->activity_deadline;
    }

    public function setActivityDeadline(\DateTimeInterface $activity_deadline): self
    {
        $this->activity_deadline = $activity_deadline;

        return $this;
    }
}
