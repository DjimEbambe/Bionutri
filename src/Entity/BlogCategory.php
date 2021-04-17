<?php

namespace App\Entity;

use App\Repository\BlogCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogCategoryRepository::class)
 */
class BlogCategory
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=BlogArticles::class, mappedBy="categories")
     */
    private $blogArticles;


    public function __construct()
    {
        $this->blogArticles = new ArrayCollection();
    }

    public function __toString(){
        return $this->getNom();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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
            $blogArticle->addCategory($this);
        }

        return $this;
    }

    public function removeBlogArticle(BlogArticles $blogArticle): self
    {
        if ($this->blogArticles->removeElement($blogArticle)) {
            $blogArticle->removeCategory($this);
        }

        return $this;
    }
}
