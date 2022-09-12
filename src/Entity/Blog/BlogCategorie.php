<?php

namespace App\Entity\Blog;

use App\Repository\Blog\BlogCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogCategorieRepository::class)]
class BlogCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $title = null;

    #[ORM\Column(length: 180)]
    private ?string $slug = null;

    #[ORM\ManyToMany(targetEntity: BlogArticle::class, mappedBy: 'categories')]
    private Collection $blogArticles;

    public function __construct()
    {
        $this->blogArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->title;
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
     * @return Collection<int, BlogArticle>
     */
    public function getBlogArticles(): Collection
    {
        return $this->blogArticles;
    }

    public function addBlogArticle(BlogArticle $blogArticle): self
    {
        if (!$this->blogArticles->contains($blogArticle)) {
            $this->blogArticles->add($blogArticle);
            $blogArticle->addCategory($this);
        }

        return $this;
    }

    public function removeBlogArticle(BlogArticle $blogArticle): self
    {
        if ($this->blogArticles->removeElement($blogArticle)) {
            $blogArticle->removeCategory($this);
        }

        return $this;
    }
}
