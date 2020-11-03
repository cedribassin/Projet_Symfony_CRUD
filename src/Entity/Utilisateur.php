<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 * @UniqueEntity(
 * fields={"username"},
 * message="Le user existe déjà"
 * )
 */
//UniqueEntity permet d'indiquer le nom d'utilisateur doit être unique => permet d'éviter
// d'avoir 2 utilisateurs avec le même nom
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
     * @Assert\Length(min=5, max=10, minMessage="Il faut plus de 5 caractères", maxMessage="Il faut moins de 10 caractères")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=5, max=10, minMessage="Il faut plus de 5 caractères", maxMessage="Il faut moins de 10 caractères")
     */
    private $password;

    /**
     * @Assert\Length(min=5, max=10, minMessage="Il faut plus de 5 caractères", maxMessage="Il faut moins de 10 caractères")
     * @Assert\EqualTo(propertyPath="password", message="Les mots de passe sont différents")
     */
    private $verificationPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $role;

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

    public function getVerificationPassword(): ?string
    {
        return $this->verificationPassword;
    }

    public function setVerificationPassword(string $verificationPassword): self
    {
        $this->verificationPassword = $verificationPassword;

        return $this;
    }

    public function getRoles(){
        return [$this->role];
    }

    public function getSalt(){

    }

    public function eraseCredentials(){

    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    //Ce setter determine le role de base pour l'utilisateur
    public function setRole(?string $role): self
    {
        //Si le role n'est pas défini (?), on envoit directement en BDD le rôle de user
        if($role === null){
            $this->role = "ROLE_USER";
        } else {
            $this->role = $role;
        }
        return $this;
    }

}
