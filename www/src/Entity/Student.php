<?php

namespace App\Entity;

use App\Entity\Calendar;
use App\Entity\PathProject;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 * @ORM\Table(name="student", indexes={@ORM\Index(columns={"firstname", "lastname", "email"}, flags={"fulltext"})})
 */
class Student
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups("post:mail")
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     *  @Groups("post:mail")
     */
    private $studentProgress;

    /**
     * @ORM\ManyToOne(targetEntity=Path::class, inversedBy="students")
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $Path;

    /**
     * @ORM\ManyToOne(targetEntity=PathProject::class, inversedBy="students")
     * @Groups("post:mail")
     */
    private $project;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("post:mail")
     */
    private $lastAppointment;

    /**
     * @ORM\OneToMany(targetEntity=Calendar::class, mappedBy="student")
     * @Groups("post:mail")
     */
    private $calendars;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("post:mail")
     */
    private $nextAppointment;

    public function __construct()
    {
        $this->calendars = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getStudentProgress(): ?int
    {
        return $this->studentProgress;
    }

    public function setStudentProgress(int $studentProgress): self
    {
        $this->studentProgress = $studentProgress;

        return $this;
    }

    public function getPath(): ?Path
    {
        return $this->Path;
    }

    public function setPath(?Path $Path): self
    {
        $this->Path = $Path;

        return $this;
    }

    public function getProject(): ?PathProject
    {
        return $this->project;
    }

    public function setProject(?PathProject $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getLastAppointment(): ?\DateTimeInterface
    {
        return $this->lastAppointment;
    }

    public function setLastAppointment(?\DateTimeInterface $lastAppointment): self
    {
        $this->lastAppointment = $lastAppointment;

        return $this;
    }

    public function getNextAppointment(): ?\DateTimeInterface
    {
        return $this->nextAppointment;
    }

    public function setNextAppointment(\DateTimeInterface $nextAppointment): self
    {
        $this->nextAppointment = $nextAppointment;

        return $this;
    }

    public function __toString()
    {
        return $this->email . ' | ' . $this->firstname . ' ' . $this->lastname;
    }

    /**
     * @return Collection|Calendar[]
     */
    public function getCalendars(): Collection
    {
        return $this->calendars;
    }

    public function addCalendar(Calendar $calendar): self
    {
        if (!$this->calendars->contains($calendar)) {
            $this->calendars[] = $calendar;
            $calendar->setStudent($this);
        }

        return $this;
    }

    public function removeCalendar(Calendar $calendar): self
    {
        if ($this->calendars->removeElement($calendar)) {
            // set the owning side to null (unless already changed)
            if ($calendar->getStudent() === $this) {
                $calendar->setStudent(null);
            }
        }

        return $this;
    }
}
