<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FotoRepository")
 * @ORM\Table(indexes={@Index(name="idx_foto", columns={"pageid"})})
 */
class Foto
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $pageid;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=45)
     */
    private $dimensions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    public function getPageid(): ?int
    {
        return $this->pageid;
    }

    public function setPageid(int $pageid): self
    {
        $this->pageid = $pageid;

        return $this;
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

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): self
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getDimensions(): ?string
    {
        return $this->dimension;
    }

    public function setDimensions(string $dimensions): self
    {
        $this->dimensions = $dimensions;

        return $this;
    }
}
