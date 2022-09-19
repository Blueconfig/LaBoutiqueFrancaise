<?php

namespace App\Entity;

use App\Entity\Blog\BlogArticle;
use App\Entity\Blog\BlogCommentaire;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 100)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    private ?string $fullname;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Adresses::class)]
    private Collection $adresses;

    #[ORM\OneToMany(mappedBy: 'relation', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'editor', targetEntity: BlogArticle::class)]
    private Collection $blogArticles;

    #[ORM\OneToMany(mappedBy: 'poster', targetEntity: BlogCommentaire::class)]
    private Collection $blogCommentaires;

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->orders = new ArrayCollection();
        $this->blogArticles = new ArrayCollection();
        $this->blogCommentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getFullname(): ?string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, Adresses>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresses $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
            $adress->setUser($this);
        }

        return $this;
    }

    public function removeAdress(Adresses $adress): self
    {
        if ($this->adresses->removeElement($adress)) {
            // set the owning side to null (unless already changed)
            if ($adress->getUser() === $this) {
                $adress->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setRelation($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getRelation() === $this) {
                $order->setRelation(null);
            }
        }

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
            $blogArticle->setEditor($this);
        }

        return $this;
    }

    public function removeBlogArticle(BlogArticle $blogArticle): self
    {
        if ($this->blogArticles->removeElement($blogArticle)) {
            // set the owning side to null (unless already changed)
            if ($blogArticle->getEditor() === $this) {
                $blogArticle->setEditor(null);
            }
        }

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
            $blogCommentaire->setPoster($this);
        }

        return $this;
    }

    public function removeBlogCommentaire(BlogCommentaire $blogCommentaire): self
    {
        if ($this->blogCommentaires->removeElement($blogCommentaire)) {
            // set the owning side to null (unless already changed)
            if ($blogCommentaire->getPoster() === $this) {
                $blogCommentaire->setPoster(null);
            }
        }

        return $this;
    }
}
