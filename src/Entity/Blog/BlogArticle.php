<?php

namespace App\Entity\Blog;

use App\Entity\User;
use App\Repository\Blog\BlogArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogArticleRepository::class)]
class BlogArticle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $title = null;

    #[ORM\Column(length: 180)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'blogArticles')]
    private ?User $editor = null;

    #[ORM\OneToMany(mappedBy: 'blogArticle', targetEntity: BlogImages::class, cascade: ['persist'])]
    private Collection $images;

    #[ORM\ManyToMany(targetEntity: BlogCategorie::class, inversedBy: 'blogArticles')]
    private Collection $categories;

    #[ORM\Column(nullable: true)]
    private ?bool $etat = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: BlogCommentaire::class)]
    private Collection $blogCommentaires;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->blogCommentaires = new ArrayCollection();
    }

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getEditor(): ?User
    {
        return $this->editor;
    }

    public function setEditor(?User $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * @return Collection<int, BlogImages>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(BlogImages $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setBlogArticle($this);
        }

        return $this;
    }

    public function removeImage(BlogImages $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBlogArticle() === $this) {
                $image->setBlogArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BlogCategorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(BlogCategorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(BlogCategorie $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(?bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * @return Collection<int, BlogCommentaire>
     */
    public function getBlogCommentaires(): Collection
    {
        return $this->blogCommentaires;
    }

    public function addBlogCommentaire(BlogCommentaire $blogCommentaire): self
    {
        if (!$this->blogCommentaires->contains($blogCommentaire)) {
            $this->blogCommentaires->add($blogCommentaire);
            $blogCommentaire->setArticle($this);
        }

        return $this;
    }

    public function removeBlogCommentaire(BlogCommentaire $blogCommentaire): self
    {
        if ($this->blogCommentaires->removeElement($blogCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($blogCommentaire->getArticle() === $this) {
                $blogCommentaire->setArticle(null);
            }
        }

        return $this;
    }
}
