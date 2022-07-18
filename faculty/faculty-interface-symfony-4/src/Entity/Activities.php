<?php

namespace App\Entity;

use App\Repository\ActivitiesRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Form\FormBuilderInterface;
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

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $activitytype;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxscore;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Course;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ProgramClass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tasktype;


    /**
     * @ORM\Column(type="boolean")
     */
    private $allowfileupload;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxattempt;

    /**
     * @ORM\Column(type="json",nullable=true)
     */
    private $timer;

    

    

    

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

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getActivitytype(): ?string
    {
        return $this->activitytype;
    }

    public function setActivitytype(string $activitytype): self
    {
        $this->activitytype = $activitytype;

        return $this;
    }

    public function getMaxscore(): ?int
    {
        return $this->maxscore;
    }

    public function setMaxscore(int $maxscore): self
    {
        $this->maxscore = $maxscore;

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

    public function getProgramClass(): ?string
    {
        return $this->ProgramClass;
    }

    public function setProgramClass(string $ProgramClass): self
    {
        $this->ProgramClass = $ProgramClass;

        return $this;
    }

    public function getTasktype(): ?string
    {
        return $this->tasktype;
    }

    public function setTasktype(string $tasktype): self
    {
        $this->tasktype = $tasktype;

        return $this;
    }

 

    public function getAllowfileupload(): ?bool
    {
        return $this->allowfileupload;
    }

    public function setAllowfileupload(bool $allowfileupload): self
    {
        $this->allowfileupload = $allowfileupload;

        return $this;
    }

    public function getMaxattempt(): ?int
    {
        return $this->maxattempt;
    }

    public function setMaxattempt(int $maxattempt): self
    {
        $this->maxattempt = $maxattempt;

        return $this;
    }

    public function getTimer(): ?array
    {
        return $this->timer;
    }

    public function setTimer(?array $timer): self
    {
        $this->timer = $timer;

        return $this;
    }

  

   
    
   
}
