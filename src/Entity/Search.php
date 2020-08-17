<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SearchRepository")
 */
class Search
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=900)
     */
    private $search_text;

    /**
     * @ORM\Column(type="integer")
     */
    private $search_times = 1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSearchText(): ?string
    {
        return $this->search_text;
    }

    public function setSearchText(string $search_text): self
    {
        $this->search_text = $search_text;

        return $this;
    }

    public function getSearchTimes(): ?int
    {
        return $this->search_times;
    }

    public function setSearchTimes(int $search_times): self
    {
        $this->search_times = $search_times;

        return $this;
    }
}
