<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(
 * fields={"username"},
 * message="Ce nom existe déjà")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3,max=10, minMessage="Le nom d'utilisateur doit être supérieur à 3", maxMessage="Le nom d'utilisateur doit être inférieur à 10")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=3,max=10, minMessage="Le nombre de caractère doit être supérieur à 3", maxMessage="Le nombre de caractère doit être inférieur à 10")
     */
    private $password;

    /**
     * @Assert\Length(min=3,max=10, minMessage="Le nombre de caractère doit être supérieur à 3", maxMessage="Le nombre de caractère doit être inférieur à 10")
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe sont différents")
     */
    private $verifPassword;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getVerifPassword(): ?string
    {
        return $this->verifPassword;
    }

    public function setVerifPassword(string $verifPassword): self
    {
        $this->verifPassword = $verifPassword;
        return $this;
    }

    public function eraseCredentials(){

    }


    public function getSalt(){

    }

    public function getRoles(){
        return ['ROLE_USER'];
    }
}
