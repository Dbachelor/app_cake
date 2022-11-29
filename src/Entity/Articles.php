<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use	 Doctrine\ORM\Tools\Pagination\Paginator;
use	 Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository	;

// #[ORM\Entity(repositoryClass: ArticlesRepository::class)]

/**
 * Articles
 *
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="App\Repository\ArticlesRepository")
 */

class Articles
{
      /**
    * @var int
    *
    * @ORM\Column(name="id", type="bigint", nullable=false)
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */

    private ?int $id = null;

    /**
    * @var string
    *
    * @ORM\Column(name="title", type="string", length=255, nullable=false)
    */
    private ?string $title = null;

     /**
    * @var string
    *
    * @ORM\Column(name="short_description", type="text", length=0, nullable=false)
    */
    private ?string $short_description = null;

     /**
    * @var string
    *
    * @ORM\Column(name="picture", type="text", length=15555555, nullable=false)
    */
    private ?string $picture = null;

      /**
    * @var string
    *
    * @ORM\Column(name="date_added", type="datetime", length=255, nullable=false)
    */
    private ?\DateTimeInterface $date_added = null;

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

    public function getShortDescription(): ?string
    {
        return $this->short_description;
    }

    public function setShortDescription(string $short_description): self
    {
        $this->short_description = $short_description;

        return $this;
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

    public function getDateAdded(): ?\DateTimeInterface
    {
        return $this->date_added;
    }

    public function setDateAdded(\DateTimeInterface $date_added): self
    {
        $this->date_added = $date_added;

        return $this;
    }




}
