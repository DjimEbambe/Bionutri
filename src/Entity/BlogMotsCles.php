<?php

namespace App\Entity;

use App\Repository\BlogMotsClesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogMotsClesRepository::class)
 */
class BlogMotsCles
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
    private $mot_cle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=BlogArticles::class, mappedBy="mots_cles")
     */
    private $blogArticles;

    public function __construct()
    {
        $this->blogArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMotCle(): ?string
    {
        return $this->mot_cle;
    }

    public function setMotCle(string $mot_cle): self
    {
        $this->mot_cle = $mot_cle;

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

    /**
     * @return Collection|BlogArticles[]
     */
    public function getBlogArticles(): Collection
    {
        return $this->blogArticles;
    }

    public function addBlogArticle(BlogArticles $blogArticle): self
    {
        if (!$this->blogArticles->contains($blogArticle)) {
            $this->blogArticles[] = $blogArticle;
            $blogArticle->addMotsCle($this);
        }

        return $this;
    }

    public function removeBlogArticle(BlogArticles $blogArticle): self
    {
        if ($this->blogArticles->removeElement($blogArticle)) {
            $blogArticle->removeMotsCle($this);
        }

        return $this;
    }
}