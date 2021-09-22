<?php

namespace App\Entity;

use App\Entity\Path;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PathProjectRepository")
 */
class PathProject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("post:mail")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:mail")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=path::class, inversedBy="pathprojects")
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:mail")
     */
    private $link;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="project")
     */
    private $students;

    /**
     * @ORM\Column(type="integer")
     * @Groups("post:mail")
     */
    private $time;

    /**
     * @ORM\Column(type="float")
     */
    private $renumerate;

    public function __construct()
    {
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPath(): ?Path
    {
        return $this->path;
    }

    public function setPath(?Path $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return Collection|Student[]
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students[] = $student;
            $student->setProject($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getProject() === $this) {
                $student->setProject(null);
            }
        }

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getRenumerate(): ?float
    {
        return $this->renumerate;
    }

    public function setRenumerate(float $renumerate): self
    {
        $this->renumerate = $renumerate;

        return $this;
    }
}
