<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $picture;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Episode", inversedBy="images")
     */
    private $episodePicture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getEpisodePicture(): ?Episode
    {
        return $this->episodePicture;
    }

    public function setEpisodePicture(?Episode $episodePicture): self
    {
        $this->episodePicture = $episodePicture;

        return $this;
    }
}
