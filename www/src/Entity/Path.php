<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PathRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PathRepository::class)
 */
class Path
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=PathCategory::class, inversedBy="paths")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity=PathCertificate::class, inversedBy="paths")
     * @ORM\JoinColumn(nullable=false)
     */
    private $certificate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

    /**
     * @ORM\OneToMany(targetEntity=PathProject::class, mappedBy="path")
     */
    private $pathprojects;

    /**
     * @ORM\OneToMany(targetEntity=Student::class, mappedBy="Path")
     */
    private $students;

    /**
     * @ORM\Column(type="integer")
     * @Groups("post:mail")
     */
    private $time;

    public function __construct()
    {
        $this->pathprojects = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getCategory(): ?PathCategory
    {
        return $this->category;
    }

    public function setCategory(?PathCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCertificate(): ?PathCertificate
    {
        return $this->certificate;
    }

    public function setCertificate(?PathCertificate $certificate): self
    {
        $this->certificate = $certificate;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection|PathProject[]
     */
    public function getPathprojects(): Collection
    {
        return $this->pathprojects;
    }

    public function addPathproject(PathProject $pathproject): self
    {
        if (!$this->pathprojects->contains($pathproject)) {
            $this->pathprojects[] = $pathproject;
            $pathproject->setPath($this);
        }

        return $this;
    }

    public function removePathproject(PathProject $pathproject): self
    {
        if ($this->pathprojects->removeElement($pathproject)) {
            // set the owning side to null (unless already changed)
            if ($pathproject->getPath() === $this) {
                $pathproject->setPath(null);
            }
        }

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
            $student->setPath($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getPath() === $this) {
                $student->setPath(null);
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

    function __toString()
    {
        return $this->name;
    }
}
