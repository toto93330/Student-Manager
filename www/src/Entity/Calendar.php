<?php

namespace App\Entity;

use App\Entity\Student;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CalendarRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CalendarRepository::class)
 */
class Calendar
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
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $end;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $allDay;

    /**
     * @ORM\Column(type="string", length=7)
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $background_color;

    /**
     * @ORM\Column(type="string", length=7)
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $border_color;

    /**
     * @ORM\Column(type="string", length=7)
     * @Groups("post:read")
     * @Groups("post:mail")
     */
    private $text_color;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="calendars")
     * @Groups("post:read")
     */
    private $student;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $validate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getAllDay(): ?bool
    {
        return $this->allDay;
    }

    public function setAllDay(bool $allDay): self
    {
        $this->allDay = $allDay;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->background_color;
    }

    public function setBackgroundColor(string $background_color): self
    {
        $this->background_color = $background_color;

        return $this;
    }

    public function getBorderColor(): ?string
    {
        return $this->border_color;
    }

    public function setBorderColor(string $border_color): self
    {
        $this->border_color = $border_color;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->text_color;
    }

    public function setTextColor(string $text_color): self
    {
        $this->text_color = $text_color;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getValidate(): ?bool
    {
        return $this->validate;
    }

    public function setValidate(?bool $validate): self
    {
        $this->validate = $validate;

        return $this;
    }
}
