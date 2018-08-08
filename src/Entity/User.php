<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     */
    private $plain_password;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=95)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="uploaded_by", orphanRemoval=true)
     */
    private $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plain_password;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plain_password = $plainPassword;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUsername(): ?string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        $this->plain_password = null;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setUploadedBy($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->contains($photo)) {
            $this->photos->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getUploadedBy() === $this) {
                $photo->setUploadedBy(null);
            }
        }

        return $this;
    }
}
