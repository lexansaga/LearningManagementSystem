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
     * @ORM\Column(type="integer")
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

    public function getStudentid(): ?int
    {
        return $this->studentid;
    }

    public function setStudentid(int $studentid): self
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
}
